<?php


namespace App\Controller;


//use Pricing\Acriss\Domain\AcrissNotFoundException;
//use Pricing\Carclass\Domain\CarclassNotFoundException;
//use Pricing\Complement\Application\CreateComplement\CreateComplementQuery;
//use Pricing\Complement\Application\CreateComplement\CreateComplementQueryHandler;
//use Pricing\Complement\Application\EditComplement\EditComplementQuery;
//use Pricing\Complement\Application\EditComplement\EditComplementQueryHandler;
//use Pricing\Complement\Application\FilterTest\FilterTestQuery;
//use Pricing\Complement\Application\FilterTest\FilterTestQueryHandler;
//use Pricing\Complement\Application\FilterComplement\FilterComplementQuery;
//use Pricing\Complement\Application\FilterComplement\FilterComplementQueryHandler;
//use Pricing\Complement\Application\FilterComplementArticle\FilterComplementArticleQuery;
//use Pricing\Complement\Application\FilterComplementArticle\FilterComplementArticleQueryHandler;
//use Pricing\Complement\Application\FilterComplementRate\FilterComplementRateQuery;
//use Pricing\Complement\Application\FilterComplementRate\FilterComplementRateQueryHandler;
//use Pricing\Complement\Application\FilterCoverageComplement\FilterCoverageComplementQuery;
//use Pricing\Complement\Application\FilterCoverageComplement\FilterCoverageComplementQueryHandler;
//use Pricing\Complement\Application\FilterDamage\FilterDamageQuery;
//use Pricing\Complement\Application\FilterDamage\FilterDamageQueryHandler;
//use Pricing\Complement\Application\FilterFeeComplement\FilterFeeComplementQuery;
//use Pricing\Complement\Application\FilterFeeComplement\FilterFeeComplementQueryHandler;
//use Pricing\Complement\Application\FilterPackageComplement\FilterPackageComplementQuery;
//use Pricing\Complement\Application\FilterPackageComplement\FilterPackageComplementQueryHandler;
//use Pricing\Complement\Application\ListComplement\ListComplementQuery;
//use Pricing\Complement\Application\ListComplement\ListComplementQueryHandler;
//use Pricing\Complement\Application\ShowComplement\ShowComplementQuery;
//use Pricing\Complement\Application\ShowComplement\ShowComplementQueryHandler;
//use Pricing\Complement\Application\StoreComplement\StoreComplementCommand;
//use Pricing\Complement\Application\StoreComplement\StoreComplementCommandHandler;
//use Pricing\Complement\Application\UpdateComplement\UpdateComplementCommand;
//use Pricing\Complement\Application\UpdateComplement\UpdateComplementCommandHandler;
//use Pricing\Complement\Domain\ComplementNotFoundException;
//use Pricing\ComplementCategory\Domain\ComplementCategoryNotFoundException;
//use Pricing\ComplementArticle\Domain\ComplementArticleNotFoundException;
//use Pricing\Delegation\Domain\DelegationNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    public function index()
    {
        return $this->render('dashboard.html.twig');
    }

}
