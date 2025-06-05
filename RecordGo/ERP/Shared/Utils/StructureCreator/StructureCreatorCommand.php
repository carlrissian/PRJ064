<?php

namespace Shared\Utils\StructureCreator;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class StructureCreatorCommand
{

    /**
     * @var InputInterface
     */
    private $input;
    /**
     * @var OutputInterface
     */
    private $output;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $sample_path_template;
    /**
     * @var string
     */
    private $sample_path_controller;
    /**
     * @var string
     */
    private $samplePath;
    /**
     * @var string
     */
    private $sample_path_route;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $identifier;

    public function __construct(InputInterface $input, OutputInterface $output)
    {

        $this->input = $input;
        $this->output = $output;
        $this->filesystem = new Filesystem();

        $this->path = 'RecordGo/ERP/';
        $this->samplePath = 'RecordGo/ERP/Shared/Utils/StructureCreator/SampleStructure';
        $this->sample_path_route = 'RecordGo/ERP/Shared/Utils/StructureCreator/config/sample';
        $this->sample_path_controller = 'RecordGo/ERP/Shared/Utils/StructureCreator/Controller/SampleController';
        $this->sample_path_template = 'RecordGo/ERP/Shared/Utils/StructureCreator/templates';
        $this->name = '';
        $this->identifier = 'id';
    }

    public function execute()
    {
        $this->output->writeln([
            '<info>',
            '*********************',
            '* Structure Creator *',
            '*********************',
            '</info>',
        ]);
        $options = false;

        $name = ucfirst($this->input->getArgument('name'));
        if (!$name) {
            $this->output->writeln(['<error>Need to specify a name</error>']);
        }

        //Set $name variable to access globally in the file
        $this->name = $name;

        $all = $this->input->getOption('all');
        if ($all) {
            $this->output->writeln(['<question>Executing option all.... ' . $name . '</question>']);
            $options = true;
        }
        $create = $this->input->getOption('create');
        if ($create) {
            $this->output->writeln(['<question>Executing option create </question>']);
            $options = true;
        }

        $store = $this->input->getOption('store');
        if ($store) {
            $this->output->writeln(['<question>Executing option store </question>']);
            $options = true;
        }

        $edit = $this->input->getOption('edit');
        if ($edit) {
            $this->output->writeln(['<question>Executing option edit </question>']);
            $options = true;
        }

        $update = $this->input->getOption('update');
        if ($update) {
            $this->output->writeln(['<question>Executing option update </question>']);
            $options = true;
        }

        $show = $this->input->getOption('show');
        if ($show) {
            $this->output->writeln(['<question>Executing option show </question>']);
            $options = true;
        }

        $identifier = $this->input->getOption('identifier');
        if ($identifier) {
            $options = true;
            $this->identifier = $identifier;
            $this->output->writeln(['<question>Identifier used: ' . $this->identifier . '</question>']);
        }

        if (!$options) {
            $this->output->writeln(['<error>Add an option</error>']);
        }


        /**
         * Only when an option is applied
         */
        if ($name && $options) {
            $filesystem = new Filesystem();
//TODO Think about to apply automatically the name of the project. Pricing, mostrador...
            $destination_path = $this->path . $_ENV['APP_NAME'] . '/' . $name;
            try {

                //Check if folder name exists
                if ($filesystem->exists($destination_path)) {
                    if ($all) {
                        //Folder already exists so option all is not allowed.
                        $this->output->writeln(['<error>Folder already exists to use option --all.</error>']);
                    } else {
                        if ($create) {
                            try {
                                $this->createUseCase('Create');
                            } catch (\Exception $exception) {
                                $this->output->writeln('<error>An error occurred while creating use case Create </error>');
                            }
                        }
                        if ($store) {
                            try {
                                $this->createUseCase('Store');
                            } catch (\Exception $exception) {
                                $this->output->writeln('<error>An error occurred while creating use case Store </error>');
                            }
                        }
                        if ($edit) {
                            try {
                                $this->createUseCase('Edit');
                            } catch (\Exception $exception) {
                                $this->output->writeln('<error>An error occurred while creating use case Edit </error>');
                            }
                        }
                        if ($update) {
                            try {
                                $this->createUseCase('Update');
                            } catch (\Exception $exception) {
                                $this->output->writeln('<error>An error occurred while creating use case Update </error>');
                            }
                        }
                        if ($show) {
                            try {
                                $this->createUseCase('Show');
                            } catch (\Exception $exception) {
                                $this->output->writeln('<error>An error occurred while creating use case Show </error>');
                            }
                        }
                    }
                } else {
                    if ($all) {
                        $this->createConfigRoutes();
                        $this->createController();
                        $this->createTemplate();
                        $filesystem->mirror($this->samplePath, $destination_path);
                        $this->loop_dir($destination_path);
                    } else {
                        $this->output->writeln(['<error>Folder ' . $name . ' doesn\'t exists.</error>']);
                    }
                }


            } catch (IOExceptionInterface $exception) {
                $this->output->writeln(['<error>An error occurred while creating your directory at ' . $exception->getPath() . '</error>']);
            }
        }
    }


    /**
     * $path = The path where the loop will start.
     * Loop to get all dir and folders by path
     */
    private function loop_dir($path)
    {
        $structure = scandir($path);
        foreach ($structure as $key => $value) {
            if ($key >= 2) {
                $check_path = $path . '/' . $value;
                $this->check_path($check_path);
            }
        }
    }

    /**
     * Determine is the element is a directory or a file.
     * Directory: Will change the name and start new loop.
     * File: Will change the file name and content.
     */
    private function check_path($path)
    {
        //the path is a directory
        if (is_dir($path)) {
            $oldPathName = $path;
            //Replace Sample to $name on the folder
            $path = str_replace('Sample', $this->name, $path);
            rename($oldPathName, $path);
            $this->loop_dir($path);
        }
        //the path is a file
        if (is_file($path)) {
            $this->replace_content_file($path);
        }
    }

    private function replace_content_file($path)
    {
        $oldPathName = $path;
        //Replace Sample to $name on the file name
        $path = str_replace('Sample', $this->name, $oldPathName);
        if (!strpos($path, '.yaml') && !strpos($path, '.html.twig')) {
            //Add .php this prevent possible errors.
            rename($oldPathName, $path . '.php');
            $path = $path . '.php';
        }

        //Open file
        $str = file_get_contents($path);
        //Replace slash to backslash / to \
        $parentPath = $this->replace_slash(dirname($path));

        //Search if exists in that file some identifier to change.
        if (stripos($str, 'sampleIdentifier')) {
            $str = str_replace(array('$sampleIdentifier', 'sampleIdentifier', 'SampleIdentifier'), array('$' . strtolower($this->identifier), $this->identifier, ucfirst($this->identifier)), $str);
        }

        //Only to add use repository
        if (strpos($str, 'ProjectName')) {
            $projectName = $_ENV['APP_NAME'];

            $str = str_replace('ProjectName', $projectName, $str);
        }
        //Replace the namespace, Replace Sample to $name
        $str = str_replace(array('$sample', 'SampleNamespace', 'Sample', 'sample'), array('$' . strtolower($this->name), $parentPath, $this->name, strtolower($this->name)), $str);

        //Save the changes
        file_put_contents($path, $str);

        $this->output->writeln('<info>Created: ' . $path . '</info>');


    }

    /**
     * Replace slash and root path, used with namespaces and use.
     */
    private function replace_slash($subject)
    {
        return str_replace(array('/', 'RecordGo\ERP\\'), array('\\', ''), $subject);
    }

    private function createUseCase($option)
    {
        $destination_path = $this->path . $_ENV['APP_NAME'] . '/' . $this->name . '/Application';
        $destination_path_to_replace = $destination_path . '/' . $option . 'Sample';
        $createPath = $destination_path . '/' . $option . $this->name;
        if ($this->filesystem->exists($createPath)) {
            $this->output->writeln(['<comment>Use case ' . $option . ' already exists</comment>']);
        } else {
            $this->filesystem->mirror($this->samplePath . '/Application/' . $option . 'Sample', $destination_path_to_replace);
            //Replace Sample to $name on the folder
            $path = str_replace('Sample', $this->name, $destination_path_to_replace);
            rename($destination_path_to_replace, $path);
            $this->loop_dir($path);
        }
    }

    private function createConfigRoutes()
    {
        $nameLowerCase = strtolower($this->name);
        $configPath = 'config/routes/' . $nameLowerCase;
        if (!$this->filesystem->exists($configPath)) {
            $this->filesystem->mkdir($configPath);
            $this->filesystem->copy($this->sample_path_route, $configPath . '/' . $nameLowerCase . '.yaml');
            $this->replace_content_file($configPath . '/' . $nameLowerCase . '.yaml');
        } else {
            $this->output->writeln(['<comment>Route folder with name ' . $nameLowerCase . ' already exists.</comment>']);
        }
    }

    private function createController()
    {
        $controllerPath = 'src/Controller/' . $this->name . 'Controller';

        if (!$this->filesystem->exists($controllerPath . '.php')) {
            $this->filesystem->copy($this->sample_path_controller, $controllerPath);
            $this->replace_content_file($controllerPath);
        } else {
            $this->output->writeln(['<comment>Controller with name ' . $this->name . ' already exists.</comment>']);
        }
    }

    private function createTemplate()
    {
        $templatePath = 'templates/' . strtolower($this->name);
        if (!$this->filesystem->exists($templatePath)) {
            $this->filesystem->mirror($this->sample_path_template, $templatePath);
            $this->loop_dir($templatePath);
        } else {
            $this->output->writeln(['<comment>Folder template with name ' . $this->name . ' already exists.</comment>']);
        }
    }

    //TODO Añadir ficheros Vue, tambien añadir las rutas en app.js. Primero deben tener todos los proyectos la misma estructura de carpetas en Vue.

}