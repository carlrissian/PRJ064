var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')


    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', [
        './assets/js/app.js',
        './assets/assets/js/theme/core/util.js',
        './assets/assets/js/theme/core/app.js',
        './assets/assets/js/theme/core/base/avatar.js',
        './assets/assets/js/theme/core/base/dialog.js',
        './assets/assets/js/theme/core/base/header.js',
        './assets/assets/js/theme/core/base/menu.js',
        './assets/assets/js/theme/core/base/offcanvas.js',
        './assets/assets/js/theme/core/base/portlet.js',
        './assets/assets/js/theme/core/base/scrolltop.js',
        './assets/assets/js/theme/core/base/toggle.js',
        './assets/assets/js/theme/core/base/wizard.js',
        './assets/assets/js/theme/demos/demo1/layout.js',
        './assets/assets/js/vendors/jquery-validation.init.js'
    ])

    // //COMPLEMENT ARTICLE
    // .addEntry('complement.article.list', [
    //     './assets/js/complementArticle/list.js',
    // ])
    // .addEntry('add-feeComplement', [
    //     './assets/js/complementArticle/modal/addFeeComplement.js',
    // ])
    // .addEntry('complementArticle-create', [
    //     './assets/js/complementArticle/validators.js',
    // ])
    // .addEntry('complementArticle-edit', [
    //     './assets/js/complementArticle/validators.js',
    // ])
    //
    // //COMPLEMENT used in sliders
    // .addEntry('complement-editclone', [
    //     './assets/js/complement/components.js'
    // ])
    // .addEntry('complement-list', [
    //     './assets/js/complement/complement-list.js',
    // ])
    // .addEntry('complement-create', [
    //     './assets/js/complement/components.js',
    //     // './assets/js/complement/validators.js',
    // ])
    // .addEntry('automatic-complement', [
    //     './assets/assets/js/theme/pages/components/portlets/draggable.js',
    //     './assets/js/complement/automaticComplements.js',
    // ])
    //
    // .addEntry('exclude-feeComplement-on-coverageComplement', [
    //     './assets/js/complement/modal/excludeFeeComplementOnCoverageComplement.js',
    // ])
    // .addEntry('add-complement-on-packageComplement', [
    //     './assets/js/complement/modal/addComplementOnPackageComplement.js',
    // ])
    //
    // .addEntry('complement-filter-complementRate', [
    //     './assets/js/complement/complement-modalComplementRate.js',
    // ])
    //
    //
    // //COMPLEMENT RATES
    // .addEntry('complement.rate.list', [
    //     './assets/js/complementRate/list.js',
    // ])
    // .addEntry('complementRate-show', [
    //     './assets/js/complementRate/complementRate-show.js',
    // ])
    // .addEntry('complementRate-serviceCharge-create', [
    //     './assets/js/complementRate/components.js',
    //     './assets/js/complementRate/serviceCharge-create.js',
    // ])
    // //COMPLEMENT FAMILY
    // .addEntry('complement.family.edit', [
    //     './assets/js/articleGroup/validators.js',
    // ])
    // .addEntry('complement.family.create', [
    //     './assets/js/articleGroup/validators.js',
    // ])
    // .addEntry('complement.family.list', [
    //     './assets/js/articleGroup/list.js',
    // ])
    // //PRODUCT
    // .addEntry('product-create', [
    //     './assets/assets/js/theme/pages/components/portlets/draggable.js',
    //     './assets/js/product/validators.js',
    //     './assets/js/product/components.js',
    //     './assets/js/product/modal/addComplementOnCondition.js',
    //     './assets/js/product/modal/addComplementOnDesk.js',
    //     './assets/js/product/modal/excludeComplementOnDesk.js',
    //     './assets/js/product/modal/addComplementOnTotem.js',
    //     './assets/js/product/modal/excludeComplementOnTotem.js',
    //     './assets/js/product/modal/addRateOnProduct.js',
    //     './assets/js/product/modules/newChannelPricing.js',
    //     './assets/js/product/modules/newFeatureDelegation.js',
    //     './assets/js/product/modules/newCondition.js',
    //     './assets/js/product/modules/feature.js',
    //     './assets/js/product/modal/addComplementOnFeature.js',
    //     './assets/js/product/modal/addComplementOnPickupOutOfHourOnFeatureDelegation.js',
    //     './assets/js/product/modal/addComplementOnDropoffOutOfHourOnFeatureDelegation.js',
    //     './assets/js/product/modal/addComplementOneWayOnFeature.js',
    //     './assets/js/product/modal/addComplementOnPickupOutOfHourOnFeature.js',
    //     './assets/js/product/modal/addComplementOnDropoffOutOfHourOnFeature.js',
    //     './assets/js/product/modal/addComplementOnAgreementExtensionOnFeature.js',
    //     './assets/js/product/modal/addComplementOnCancellationFee.js',
    //     './assets/js/product/modal/addComplementOnCancellationFeeOnFeatureDelegation.js',
    //     './assets/js/product/modal/addComplementOnAutomaticApplication.js'
    // ])
    // .addEntry('product-list', [
    //     './assets/js/product/product-list.js',
    // ])
    // .addEntry('product-edit',[
    //     './assets/assets/js/theme/pages/components/portlets/draggable.js',
    //     './assets/js/product/validators.js',
    //     './assets/js/product/components.js',
    //     './assets/js/product/modal/addComplementOnDesk.js',
    //     './assets/js/product/modal/addComplementOnCondition.js',
    //     './assets/js/product/modal/excludeComplementOnDesk.js',
    //     './assets/js/product/modal/addComplementOnTotem.js',
    //     './assets/js/product/modal/excludeComplementOnTotem.js',
    //     './assets/js/product/modal/addRateOnProduct.js',
    //     './assets/js/product/modules/newChannelPricing.js',
    //     './assets/js/product/modules/newFeatureDelegation.js',
    //     './assets/js/product/modules/newCondition.js',
    //     './assets/js/product/modules/feature.js',
    //     './assets/js/product/modal/addComplementOnFeature.js',
    //     './assets/js/product/modal/addComplementOnPickupOutOfHourOnFeatureDelegation.js',
    //     './assets/js/product/modal/addComplementOnDropoffOutOfHourOnFeatureDelegation.js',
    //     './assets/js/product/modal/addComplementOneWayOnFeature.js',
    //     './assets/js/product/modal/addComplementOnPickupOutOfHourOnFeature.js',
    //     './assets/js/product/modal/addComplementOnDropoffOutOfHourOnFeature.js',
    //     './assets/js/product/modal/addComplementOnAgreementExtensionOnFeature.js',
    //     './assets/js/product/modal/addComplementOnCancellationFee.js',
    //     './assets/js/product/modal/addComplementOnCancellationFeeOnFeatureDelegation.js',
    //     './assets/js/product/modal/addComplementOnAutomaticApplication.js'
    //
    // ])
    //
    // //RATE
    // .addEntry('rate-create', [
    //     './assets/js/rate/validators.js',
    // ])
    // .addEntry('rate-show', [
    //     './assets/js/rate/rate-show.js',
    // ])
    // .addEntry('rate-list', [
    //     './assets/js/rate/rate-list.js',
    // ])
    //
    // //FUEL POLICY
    // .addEntry('fuelPolicy-list', [
    //     './assets/js/fuelPolicy/fuelPolicy-list.js',
    // ])
    // .addEntry('fuelPolicy-create', [
    //     './assets/js/fuelPolicy/fuelPolicy-complement-selector.js',
    //     './assets/js/fuelPolicy/validators.js',
    // ])
    // .addEntry('fuelPolicy-edit', [
    //     './assets/js/fuelPolicy/fuelPolicy-complement-selector.js',
    //     './assets/js/fuelPolicy/validators.js',
    // ])
    //
    // //MILEAGE POLICY
    // .addEntry('mileagePolicy-list', [
    //     './assets/js/mileagePolicy/mileagePolicy-list.js',
    // ])
    // .addEntry('mileagePolicy-create', [
    //     './assets/js/mileagePolicy/mileagePolicyLimitedOption.js',
    //     './assets/js/mileagePolicy/mileagePolicy-addExtraMileageComplement.js',
    //     './assets/js/mileagePolicy/validators.js',
    // ])
    // .addEntry('mileagePolicy-edit', [
    //     './assets/js/mileagePolicy/mileagePolicyLimitedOption.js',
    //     './assets/js/mileagePolicy/mileagePolicy-addExtraMileageComplement.js',
    //     './assets/js/mileagePolicy/validators.js',
    // ])
    //
    // //CHANNELS
    //
    // //PARTNERS
    // .addEntry('partner-list', [
    //     './assets/js/partner/partner-list.js',
    // ])
    // .addEntry('partner-edit', [
    //     './assets/assets/js/theme/pages/components/portlets/draggable.js',
    //     './assets/js/partner/modal/addPreBookingComplementOnPartner.js',
    //     './assets/js/partner/contact.js',
    // ])

    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    //enables VUE.js
    .enableVueLoader()

    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
    })
    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')
;

module.exports = Encore.getWebpackConfig();
