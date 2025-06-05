<?php

namespace Shared\Utils\MenuTopCreator;

class MenuTopCreator
{

    public function getInfoMenu( array $user ): array
    {
        $response = [
            'countryFlag'  => $this->getFlag( $user['COUNTRY_ID'] ),
            'environment' => $this->getEnvironment(),
        ];

        return $response;
    }

    private function getEnvironment()
    {

        if( $_ENV['APP_ENV'] === 'local' )
            return  [
                'class' => 'badge-primary',
                'name' => 'Local'
            ];

        if( $_ENV['APP_ENV'] === 'dev' )
            return  [
                'class' => 'badge-info',
                'name' => 'Development'
            ];

        if( $_ENV['APP_ENV'] === 'pre' )
            return  [
                'class' => 'badge-danger',
                'name' => 'Pre-production'
            ];

        return null;
    }
    
    /**
     * @param string $countryIso
     * @return array
     */
    private function getFlag( string $countryIso ): array
    {

        $countryIso = strtolower($countryIso);
        $flagList = [
            'es' => [
                'countryName' => 'Spain',
                'flag' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAYBJREFUWIXtlstOU1EUhr+1u88uVVooDWkJXtJEAw5ImBRmzkgaXoBHYO5j+QCGIRrDzJEmAorSVKBG0gtI6DktZzEiThh4NuQwOd98r//Pvy7ZkJGR8cDI+7WVulPXjEVNmsJGJRaJtqzDvcPIokHS1AcBVbdrFGrpKv9DoZZq7LdhSy9CJOX0b1AFGX2q90Rk2q+AchUrNucXpKr2rddL4Ou3EbtfxpyHhleLhsZy4FXHy8DxrxF/DsZ83O4jRilGRaoVePrEIgn76ZXdh+8VpC3k25aF1Tc8Xtpg52AmsbiXgfBSyZ3M0dqL6Uw+YxAJ4+Ecrluj+/sqsYHELTA5yEnA7OshL3e6cPiW/MUZ5vmK1ylLnEDghJ+TFxRKATPlEfNBSOFRzL78xU0lH0SvNWyd5pkvhwyGRaKxUC0OOOpNUJ2KcFb/u46q9uXzZsP7DtwZ1b49/5H3mt770Ve/NbxPjEDnocQFOlaI1hXXFE33Q6IisSBbaWpmZGTcyjUPeHum7LKKUQAAAABJRU5ErkJggg=='
                ],
            'gr' => [
                'countryName' => 'Greece',
                'flag' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAYJJREFUWIXtlssrRGEYh59vznfG/VbTGLGgKCElFpaKxWRhJWXrP7BlbyHZWNpY2Vgqhi0lZYEoE6UGNa4z7jHjvBbDsSGzOOfM5jzrt35Pb7/v7QMfH58Cozon15pMQ0cFFehpqmF6pJ2V3SQzayfuBiNW5iMb02ZAr4BqVUDQUFSVmpQUGShX43MKZkAfaYHIf2HRzlqaw2WOKwhEdD6Dfa0hBtrDjgsAqNh+MgVUA4QqgnQ31nB+98rhxYM9dHL5zPXjm+PhIqSViNgCfzGxdMj6wZULApJWY/M7KZSqBuior2Q82sxG/IaFzYQ9ONRVR0ut8x0A0no3cY9SuRqWBg0Abp/e2Uvc21OjvQ201Ve6IUBeJZxajjMbc/4uiAi6vFijvl59iZnbgGkEKC/6cbMseHn7cF4AyKuELpLWp9fPHly93xFAD89t2yX0XEAE3d8WppArKHwHFrfOCpSdQ8+uHie/L6HniCR1xsoOfn9IvMxWiJWxsjEvM318fH7lExDKeqEfj5WyAAAAAElFTkSuQmCC'
            ],
            'ic' => [
                'countryName' => 'Canary Islands',
                'flag' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAYBJREFUWIXtlstOU1EUhr+1u88uVVooDWkJXtJEAw5ImBRmzkgaXoBHYO5j+QCGIRrDzJEmAorSVKBG0gtI6DktZzEiThh4NuQwOd98r//Pvy7ZkJGR8cDI+7WVulPXjEVNmsJGJRaJtqzDvcPIokHS1AcBVbdrFGrpKv9DoZZq7LdhSy9CJOX0b1AFGX2q90Rk2q+AchUrNucXpKr2rddL4Ou3EbtfxpyHhleLhsZy4FXHy8DxrxF/DsZ83O4jRilGRaoVePrEIgn76ZXdh+8VpC3k25aF1Tc8Xtpg52AmsbiXgfBSyZ3M0dqL6Uw+YxAJ4+Ecrluj+/sqsYHELTA5yEnA7OshL3e6cPiW/MUZ5vmK1ylLnEDghJ+TFxRKATPlEfNBSOFRzL78xU0lH0SvNWyd5pkvhwyGRaKxUC0OOOpNUJ2KcFb/u46q9uXzZsP7DtwZ1b49/5H3mt770Ve/NbxPjEDnocQFOlaI1hXXFE33Q6IisSBbaWpmZGTcyjUPeHum7LKKUQAAAABJRU5ErkJggg=='
            ],
            'it' => [
                'countryName' => 'Italy',
                'flag' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAKRJREFUWIXtkLENwkAQBHcP8zU4ISAjJKIAIguJAuiBhCZIqIbEskQjBBRgUQKIOzLC9wdYTnbi1dzoACHExHB/PS7dUsNwyw23iw1O60OR9HE543lrsxsLOvnqKszmrQErMHsfZNHt39YGfCAQke4Wgbpc/V8CqAcyx0cBClCAAhSgACPRT3WcQF/h8965pYaW/0ZEuTgCYHh+QzrBrtwqhBiJLzdWI6WoxP6wAAAAAElFTkSuQmCC'
            ],
            'pt' => [
                'countryName' => 'Portugal',
                'flag' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAoFJREFUWIXtls1PE0EYh5+Z3XbbUijUCq0FC0YSEiPGIIKJGMNFgtHEExdjYsLF/8C/w7/Ai3dNjJAYL35cSEgMicpHIiWBUrBQ+rntbrvjyQQPtqXFcOlzfmfeJ/PO/nagTZs2Z4yYmn88JHU54yBkIwsum0XmE4mWG0slHCGsRV1zyXcIMaI1vFIgG3OtjQCl3Ku6A+FGtvO7qowNaMTcLiqDQcRuCfGzgEQ07aAgrNctUoq7gw5zEx2EerwUTZsO33nKVpWdtUPKbxK4jipNS9QVuB21uBXo5Nv7HCOmzZq7SLRiIBXEgz7O3e/FeZ3EKDinL9DlqvB0Ooi5KcgX04SmHlLWSwSVm8rWJmpvg4tX+/iRLMOHg6YEao7/RkzHa2iokoOR0wg/mmPZvIQ2fo/AlTGMjMJxFNGbvVQbvsV/U/ME/NImX7AoeSUbEYvVt0t0d/lYWoljJHcw+2w6yxXyJZuyT+LLnXwMNQU0XSca6cLYs/An3NjDF9j9lSEcCuDJB1B7Bj0BDx5DJ1tVJ24OdUawmYb9VAGzA7btLB3pDTL5EqGAh/j6Z9J+h1K5QiKe+T+XcGVXsRrPMjrcA5NRDl++YCw8TH7hEMudJvxgiHyxAN+zSNFcHtQUcJC8+urQGzSZmO4mHQuQW8/hHvAyeT1EVZokPqVQX1LoTQaSFhu/9lwI4flXQc4SLG/ZCMukvx9EBIyIILWfIbGwjfx4gKaaTsOSuPPsSVoK0d1ItSGrjLosZrf3cWcqLcUwgFLqqG4SHqfsaKSOwJOpQovN/3AKv7UWBSQkz6q5gKRetZ1ZqcsZ0eCDBEchVHPf/HGUEI5ALLa8UZs2bVrlNy8H7RzUoPGGAAAAAElFTkSuQmCC'
            ],

        ];

        if( isset( $flagList[$countryIso] ) )
            return $flagList[$countryIso];

        return [ 'countryName' => strtoupper($countryIso ), 'flag' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6OTNBMEQ3QzgxRjJFMTFFRjgzOTdGRkVFM0JDQjgzRDYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6OTNBMEQ3QzkxRjJFMTFFRjgzOTdGRkVFM0JDQjgzRDYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo5M0EwRDdDNjFGMkUxMUVGODM5N0ZGRUUzQkNCODNENiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo5M0EwRDdDNzFGMkUxMUVGODM5N0ZGRUUzQkNCODNENiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PgTLIVEAAAElSURBVHjaYvz//z/DQAImhgEGow4YdcCAO4Dl+MGDikDaYwAc8w+Id7AAiW1ArDFAAXAD5GuJAYwBCRZydX789Inh48ePYLacrCz5aYAcTU3t7QyPnzyB8wX4+RliIyMZ9HR16ZMLPn/+zODp5sYQExHBICsjw/ABGBKTZ8wAhwpdQqClvp6BnZ0dzFZUUGBo7uiARAvQIfx8fLQPAZjlIPD8xQs4W1xMjD4hAEuEx0+eZFi7YQOYn5uRgeIwmjvgwsWLYMtBaSA/O5vkoKdaUSwBDHZyLQcBxmMHDrwH5aQBKog+kB0Fs+bOZTh97hyDqZERQ1pyMn0LInDpJyeHQtPdAR6ursOnQfJiAO1/AYoCr4FskDCOdkxGHTDqgIF2AECAAQDjj03Ev85lKgAAAABJRU5ErkJggg==' ];
    }
}