<?php

Route::group(['prefix' => 'service-desk', 'middleware' => ['web', 'auth']], function () {
    \Event::listen('service.desk.activate', function () {
        $controller = new App\Plugins\ServiceDesk\Controllers\ActivateController();
        echo $controller->activate();
    });

    \Event::listen('service.desk.agent.sidebar.replace', function () {
        return 1;
    });
    \Event::listen('service.desk.agent.topbar.replace', function () {
        return 1;
    });

    \Event::listen('service.desk.admin.sidebar.replace', function () {
        return 1;
    });
    \Event::listen('service.desk.admin.topbar.replace', function () {
        return 0;
    });

    \Event::listen('service.desk.agent.sidebar', function () {
        $controller = new App\Plugins\ServiceDesk\Controllers\InterfaceController();
        echo $controller->agentSidebar();
    });

    \Event::listen('service.desk.agent.topbar', function () {
        $controller = new App\Plugins\ServiceDesk\Controllers\InterfaceController();
        echo $controller->agentTopbar();
    });
    \Event::listen('service.desk.agent.topsubbar', function () {
        $controller = new App\Plugins\ServiceDesk\Controllers\InterfaceController();
        echo $controller->agentTopSubbar();
    });

    \Event::listen('service.desk.admin.sidebar', function () {
        $controller = new App\Plugins\ServiceDesk\Controllers\InterfaceController();
        echo $controller->adminSidebar();
    });

    \Event::listen('service.desk.admin.topbar', function () {
        $controller = new App\Plugins\ServiceDesk\Controllers\InterfaceController();
        echo $controller->adminTopbar();
    });
    \Event::listen('service.desk.admin.topsubbar', function () {
        $controller = new App\Plugins\ServiceDesk\Controllers\InterfaceController();
        echo $controller->adminTopSubbar();
    });

    \Event::listen('service.desk.admin.settings', function () {
        $controller = new App\Plugins\ServiceDesk\Controllers\InterfaceController();
        echo $controller->adminSettings();
    });
    \Event::listen('App\Events\TicketDetailTable', function ($event) {
        $controller = new App\Plugins\ServiceDesk\Controllers\InterfaceController();
        echo $controller->ticketDetailTable($event);
    });

    /*
     * Admin module
     */
    Route::group(['middleware' => 'roles'], function () {
        /*
         * Product Managing Module
         */

        Route::get('products', ['as' => 'service-desk.products.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Products\ProductsController@productsindex']);

        Route::get('products/create', ['as' => 'service-desk.products.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Products\ProductsController@productscreate']);
        Route::post('products/create', ['as' => 'service-desk.post.products', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Products\ProductsController@productshandleCreate']);
        Route::get('products/{id}/edit', ['as' => 'service-desk.products.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Products\ProductsController@productsedit']);
        Route::patch('products/{id}', ['as' => 'service-desk.products.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Products\ProductsController@productshandleEdit']);
        Route::get('products/{id}/delete', ['as' => 'service-desk.products.delete', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Products\ProductsController@productsHandledelete']);
        Route::get('get-products', ['as' => 'service-desk.products.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Products\ProductsController@getProducts']);
        Route::post('products/add/vendor', ['as' => 'products.vendor.add', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Products\ProductsController@addVendor']);
        Route::get('products/{productid}/remove/{vendorid}/vendor', ['as' => 'products.vendor.add', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Products\ProductsController@removeVendor']);
        Route::post('products/add-existing/vendor', ['as' => 'products.vendor.add', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Products\ProductsController@addExistingVendor']);

        /*
         * Contract Managing Module
         */
        Route::get('contracts', ['as' => 'service-desk.contract.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contract\ContractController@index']);
        Route::get('contracts/create', ['as' => 'service-desk.contract.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contract\ContractController@create']);
        Route::post('contracts/create', ['as' => 'service-desk.contract.postcreate', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contract\ContractController@handleCreate']);
        Route::get('contracts/{id}/edit', ['as' => 'service-desk.contract.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contract\ContractController@edit']);
        Route::patch('contracts/{id}', ['as' => 'service-desk.contract.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contract\ContractController@handleEdit']);
        Route::get('contracts/{id}/delete', ['as' => 'service-desk.contract.postdelete', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contract\ContractController@delete']);
        Route::get('get-contracts', ['as' => 'service-desk.contract.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contract\ContractController@getContracts']);
        //Route::get('contracts/{id}/show', ['as' => 'service-desk.contract.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contract\ContractController@show']);
        /*
         * Vendor  Managing Module
         */
        Route::get('vendor', ['as' => 'service-desk.vendor.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Vendor\VendorController@index']);
        Route::get('vendor/create', ['as' => 'service-desk.vendor.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Vendor\VendorController@create']);
        Route::post('vendor/create', ['as' => 'service-desk.vendor.postcreate', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Vendor\VendorController@handleCreate']);
        Route::get('vendor/{id}/edit', ['as' => 'service-desk.vendor.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Vendor\VendorController@edit']);
        Route::patch('vendor/{id}', ['as' => 'service-desk.vendor.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Vendor\VendorController@handleEdit']);
        Route::get('vendor/{id}/delete', ['as' => 'service-desk.vendor.postdelete', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Vendor\VendorController@delete']);
        Route::get('get-vendors', ['as' => 'service-desk.vendor.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Vendor\VendorController@getVendors']);
        //Route::get('vendor/{id}/show', ['as' => 'service-desk.vendor.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Vendor\VendorController@show']);

        /*
         * Assets type Managing Module
         */
        Route::get('assetstypes', ['as' => 'service-desk.assetstypes.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assetstypes\AssetstypesController@index']);
        Route::get('assetstypes/create', ['as' => 'service-desk.assetstypes.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assetstypes\AssetstypesController@create']);
        Route::post('assetstypes/create', ['as' => 'service-desk.post.assetstypes', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assetstypes\AssetstypesController@handleCreate']);
        Route::get('assetstypes/{id}/edit', ['as' => 'service-desk.assetstypes.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assetstypes\AssetstypesController@edit']);
        Route::patch('assetstypes/{id}', ['as' => 'service-desk.assetstypes.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assetstypes\AssetstypesController@handleEdit']);
        Route::get('assetstypes/{id}/delete', ['as' => 'service-desk.assetstypes.delet', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assetstypes\AssetstypesController@assetHandledelete']);
        Route::get('get-assetstypes', ['as' => 'service-desk.assetstypes.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assetstypes\AssetstypesController@getAssetstypes']);
        Route::get('asset-types/form/{assetid?}', ['as' => 'service-desk.assetstypes.form', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assetstypes\AssetstypesController@renderForm']);

        /*
         * Contract type Managing Module
         */
        Route::get('contract-types', ['as' => 'service-desk.contractstypes.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contracttypes\ContracttypeController@index']);
        Route::get('contract-types/create', ['as' => 'service-desk.contractstypes.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contracttypes\ContracttypeController@create']);
        Route::post('contract-types/create', ['as' => 'service-desk.post.contractstypes', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contracttypes\ContracttypeController@handleCreate']);
        Route::get('contract-types/{id}/edit', ['as' => 'service-desk.contractstypes.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contracttypes\ContracttypeController@edit']);
        Route::patch('contract-types/{id}', ['as' => 'service-desk.contractstypes.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contracttypes\ContracttypeController@handleEdit']);
        Route::get('contract-types/{id}/delete', ['as' => 'service-desk.contractstypes.delet', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contracttypes\ContracttypeController@handledelete']);
        Route::get('get-contract-types', ['as' => 'service-desk.contractstypes.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contracttypes\ContracttypeController@getContract']);

        /*
         * License type Managing Module
         */
        Route::get('license-types', ['as' => 'service-desk.licensetypes.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Licensetypes\LicensetypeController@index']);
        Route::get('license-types/create', ['as' => 'service-desk.licensetypes.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Licensetypes\LicensetypeController@create']);
        Route::post('license-types/create', ['as' => 'service-desk.post.licensetypes', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Licensetypes\LicensetypeController@handleCreate']);
        Route::get('license-types/{id}/edit', ['as' => 'service-desk.licensetypes.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Licensetypes\LicensetypeController@edit']);
        Route::patch('license-types/{id}', ['as' => 'service-desk.licensetypes.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Licensetypes\LicensetypeController@handleEdit']);
        Route::get('license-types/{id}/delete', ['as' => 'service-desk.licensetypes.delete', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Licensetypes\LicensetypeController@handledelete']);
        Route::get('get-license-types', ['as' => 'service-desk.licensetypes.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Licensetypes\LicensetypeController@getLicense']);
        //Route::get('license-types/{id}/show', ['as' => 'service-desk.licensetypes.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Licensetypes\LicensetypeController@show']);

        /*
         * Location Catagory Managing Module
         */
        Route::get('location-category-types', ['as' => 'service-desk.location-category.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Locationcategory\LocationCategoryController@index']);
        Route::get('location-category-types/create', ['as' => 'service-desk.location-category.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Locationcategory\LocationCategoryController@create']);
        Route::post('location-category-types/create', ['as' => 'service-desk.post.location-category', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Locationcategory\LocationCategoryController@handleCreate']);
        Route::get('location-category-types/{id}/edit', ['as' => 'service-desk.location-category.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Locationcategory\LocationCategoryController@edit']);
        Route::patch('location-category-types/{id}', ['as' => 'service-desk.location-category.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Locationcategory\LocationCategoryController@handleEdit']);
        Route::get('location-category-types/{id}/delete', ['as' => 'service-desk.location-category.delet', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Locationcategory\LocationCategoryController@handledelete']);
        Route::get('get-location-category-types', ['as' => 'service-desk.location-category.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Locationcategory\LocationCategoryController@getLocation']);

        /*
         * Location Managing Module
         */
        Route::get('location-types', ['as' => 'service-desk.location.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Location\LocationController@index']);
        Route::get('location-types/create', ['as' => 'service-desk.location.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Location\LocationController@create']);
        Route::post('location-types/create1', ['as' => 'service-desk.post.location', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Location\LocationController@handleCreate']);
        Route::get('location-types/{id}/edit', ['as' => 'service-desk.location.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Location\LocationController@edit']);
        Route::post('location-types/postedit1', ['as' => 'service-desk.location.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Location\LocationController@handleEdit']);
        Route::get('location-types/{id}/delete', ['as' => 'service-desk.location.delete', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Location\LocationController@handledelete']);
        Route::get('get-location-types', ['as' => 'service-desk.location.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Location\LocationController@getLocation']);
        Route::get('location-types/{id}/show', ['as' => 'service-desk.location.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Location\LocationController@show']);
        Route::get('location/org', ['as'=>'org.location', 'uses'=>'App\Plugins\ServiceDesk\Controllers\Location\LocationController@getLocationsForForm']);
        /*
         * Procurment  Managing Module
         */
        Route::get('procurement/create', ['as' => 'service-desk.procurment.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Procurment\ProcurmentController@create']);
        Route::post('procurement/create', ['as' => 'service-desk.procurment.postcreate', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Procurment\ProcurmentController@handleCreate']);
        Route::get('procurement', ['as' => 'service-desk.procurment.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Procurment\ProcurmentController@index']);
        Route::get('procurement/{id}/edit', ['as' => 'service-desk.procurment.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Procurment\ProcurmentController@edit']);
        //Route::post('procurment/edit', ['as' => 'service-desk.procurment.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Procurment\ProcurmentController@handleEdit']);
        Route::get('procurement/{id}/delete', ['as' => 'service-desk.procurment.postdelete', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Procurment\ProcurmentController@delete']);
        Route::get('get-procurement', ['as' => 'service-desk.procurment.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Procurment\ProcurmentController@getProcurment']);
        //Route::get('get-procurment', ['as' => 'service-desk.procurment.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Procurment\ProcurmentController@viewProcurment']);
        Route::patch('procurement/{id}', ['as' => 'service-desk.procurment.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Procurment\ProcurmentController@handleEdit']);

        /*
         * Form Builder
         */
        Route::get('form-builder', ['as' => 'form.builder.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\FormBuilder\FormBuilderController@index']);
        Route::get('form-builder/get-form', ['as' => 'form.builder.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\FormBuilder\FormBuilderController@getForm']);
        Route::get('form-builder/create', ['as' => 'form.builder.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\FormBuilder\FormBuilderController@create']);
        Route::post('form-builder/create', ['as' => 'form.builder.store', 'uses' => 'App\Plugins\ServiceDesk\Controllers\FormBuilder\FormBuilderController@store']);
        Route::get('form-builder/{id}', ['as' => 'form.builder.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\FormBuilder\FormBuilderController@renderHtmlByFormId']);
        Route::get('form-builder/{id}/show', ['as' => 'form.builder.view', 'uses' => 'App\Plugins\ServiceDesk\Controllers\FormBuilder\FormBuilderController@show']);
        Route::get('form-builder/{id}/edit', ['as' => 'form.builder.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\FormBuilder\FormBuilderController@edit']);
        Route::patch('form-builder/{id}', ['as' => 'form.builder.update', 'uses' => 'App\Plugins\ServiceDesk\Controllers\FormBuilder\FormBuilderController@update']);
        Route::get('form-builder/{id}/delete', ['as' => 'form.builder.delete', 'uses' => 'App\Plugins\ServiceDesk\Controllers\FormBuilder\FormBuilderController@delete']);
        /*
         * Cab
         */
        Route::resource('cabs', 'App\Plugins\ServiceDesk\Controllers\Cab\CabController');
        Route::get('cab/get-cab', ['as' => 'cabs.get.ajax', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Cab\CabController@getCab']);
        Route::get('cabs/vote/{cabid}/{owner}', ['as' => 'cabs.get.vote', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Cab\CabController@vote']);
        Route::post('cabs/vote/{cabid}/{owner}', ['as' => 'cabs.post.vote', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Cab\CabController@postVote']);
        Route::get('cabs/{cabid}/{owner}/show', ['as' => 'cabs.vote.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Cab\CabController@showVotes']);

        /*
         * Announcement
         */
        Route::get('announcement', ['as'=>'announcement', 'uses'=>'App\Plugins\ServiceDesk\Controllers\Announcement\AnnouncementController@setAnnounce']);
        Route::post('announcement', ['as'=>'announcement.post', 'uses'=>'App\Plugins\ServiceDesk\Controllers\Announcement\AnnouncementController@send']);
    });
    /*
     * Agent module
     */
    Route::group(['middleware' => 'roles'], function () {
        /*
         * Asset Managing Module
         */
        Route::get('assets', ['as' => 'service-desk.asset.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@index']);
        Route::get('assets/create', ['as' => 'service-desk.asset.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@create']);
        Route::post('assets/create', ['as' => 'service-desk.post.asset', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@handleCreate']);
        Route::get('assets/{id}/edit', ['as' => 'service-desk.asset.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@edit']);
        Route::patch('assets/{id}', ['as' => 'service-desk.asset.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@handleEdit']);
        Route::get('assets/{id}/delete', ['as' => 'service-desk.asset.delet', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@assetHandledelete']);
        Route::get('get-assets', ['as' => 'service-desk.asset.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@getAsset']);
        Route::get('assets/tag', ['as' => 'service-desk.asset.tag', 'uses' => 'App\Plugins\ServiceDesk\Controllers\assets\AssetController@search']);
        Route::post('attach-asset/ticket', ['as' => 'service-desk.post.asset.tag', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@attachAssetToTicket']);
        Route::post('assets/assettype', ['as' => 'service-desk.post.asset.types', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@assetType']);
        Route::get('asset-type/{id}', ['as' => 'service-desk.post.asset.type', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@getAssetType']);
        Route::get('asset/detach/{ticketid}', ['as' => 'service-desk.post.asset.detach', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@detach']);
        Route::get('assets/{id}/show', ['as' => 'service-desk.asset.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@show']);
        Route::get('assets/requesters', ['as' => 'asset.requesters.ajax', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@ajaxRequestTable']);
        Route::get('assets/export', ['as' => 'asset.export', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@export']);
        Route::post('assets/export', ['as' => 'asset.export.post', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Assets\AssetController@exportAsset']);

        /*
         * Release Managing Module
         */
        Route::get('releases', ['as' => 'service-desk.releases.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Releses\RelesesController@releasesindex']);
        Route::get('releases/create', ['as' => 'service-desk.releases.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Releses\RelesesController@releasescreate']);
        Route::post('releases/create', ['as' => 'service-desk.post.releases', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Releses\RelesesController@releaseshandleCreate']);
        Route::get('releases/{id}/edit', ['as' => 'service-desk.releases.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Releses\RelesesController@releasesedit']);
        Route::patch('releases/{id}', ['as' => 'service-desk.releases.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Releses\RelesesController@releaseshandleEdit']);
        Route::get('releases/{id}/delete', ['as' => 'service-desk.releases.delete', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Releses\RelesesController@releasesHandledelete']);
        Route::get('releases/{id}/show', ['as' => 'service-desk.releases.view', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Releses\RelesesController@view']);
        Route::get('get-releases', ['as' => 'service-desk.releases.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Releses\RelesesController@getReleases']);
        Route::get('releases/{id}/complete', ['as' => 'service-desk.releases.view', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Releses\RelesesController@complete']);

        /*
         * Changes Managing Module
         */
        Route::get('changes', ['as' => 'service-desk.changes.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@changesindex']);
        Route::get('changes/create', ['as' => 'service-desk.changes.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@changescreate']);
        Route::post('changes/create', ['as' => 'service-desk.post.changes', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@changeshandleCreate']);
        Route::get('changes/{id}/edit', ['as' => 'service-desk.changes.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@changesedit']);
        Route::patch('changes/{id}', ['as' => 'service-desk.changes.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@changeshandleEdit']);
        Route::get('changes/{id}/delete', ['as' => 'service-desk.changes.delete', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@changesHandledelete']);
        Route::get('get-changes', ['as' => 'service-desk.changes.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@getChanges']);
        Route::get('changes/{id}/show', ['as' => 'service-desk.changes.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@show']);
        Route::get('changes/{id}/close', ['as' => 'change.close', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@close']);
        Route::post('changes/release/{id}', ['as' => 'change.release.post', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@attachNewRelease']);
        Route::get('changes/release', ['as' => 'change.release', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@getReleases']);
        Route::post('changes/release/attach/{id}', ['as' => 'change.release.attach', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@attachExistingRelease']);
        Route::get('changes/{changeid}/detach', ['as' => 'change.release.detach', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Changes\ChangesController@detachRelease']);

        /*
         * Problem Managing Module
         */
        Route::get('problems', ['as' => 'service-desk.problem.index', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@index']);
        Route::get('problem/create', ['as' => 'service-desk.problem.create', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@create']);
        Route::post('problem/create', ['as' => 'service-desk.problem.postcreate', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@handleCreate']);
        Route::get('problem/{id}/edit', ['as' => 'service-desk.problem.edit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@edit']);
        Route::patch('problem/{id}', ['as' => 'service-desk.problem.postedit', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@handleEdit']);
        Route::get('problem/{id}/delete', ['as' => 'service-desk.problem.postdelete', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@delete']);
        Route::get('get-problems', ['as' => 'service-desk.problem.get', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@getproblems']);
        Route::post('attach-problem/ticket/new', ['as' => 'attach.problem.ticket.new', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@attachNewProblemToTicket']);
        Route::post('attach-problem/ticket/existing', ['as' => 'attach.problem.ticket.existing', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@attachExistingProblemToTicket']);
        Route::get('problems/attach/existing', ['as' => 'attach.problem.ticket.existing.ajax', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@getAttachableProblem']);
        Route::get('problem/detach/{ticketid}', ['as' => 'detach.problem.ticket', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@detach']);
        Route::get('problem/{id}/show', ['as' => 'show.problem', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@show']);
        Route::get('problem/{id}/close', ['as' => 'problem.close', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@close']);
        Route::post('problem/change/{id}', ['as' => 'problem.change.post', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@attachNewChange']);
        Route::get('problem/change', ['as' => 'problem.change', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@getChanges']);
        Route::post('problem/change/attach/{id}', ['as' => 'problem.change.attach', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@attachExistingChange']);
        Route::get('problem/{problemid}/detach', ['as' => 'problem.change.detach', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Problem\ProblemController@detachChange']);

        /*
         * Common
         */

        Route::get('products/{id}/show', ['as' => 'service-desk.products.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Products\ProductsController@show']);
        Route::get('contracts/{id}/show', ['as' => 'service-desk.contract.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Contract\ContractController@show']);
        Route::get('vendor/{id}/show', ['as' => 'service-desk.vendor.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Vendor\VendorController@show']);
        Route::get('cabs/{cabid}/{owner}/show', ['as' => 'cabs.vote.show', 'uses' => 'App\Plugins\ServiceDesk\Controllers\Cab\CabController@showVotes']);
        Route::post('general/{id}/{table}', ['as'=>'general.post', 'uses'=>'App\Plugins\ServiceDesk\Controllers\InterfaceController@generalInfo']);
        Route::get('delete/{attachid}/{owner}/attachment', ['as'=>'attach.delete', 'uses'=>'App\Plugins\ServiceDesk\Controllers\InterfaceController@deleteAttachments']);
        Route::get('download/{attachid}/{owner}/attachment', ['as'=>'attach.delete', 'uses'=>'App\Plugins\ServiceDesk\Controllers\InterfaceController@downloadAttachments']);
        Route::get('general/{owner}/{identifier}/delete', ['as'=>'attach.delete', 'uses'=>'App\Plugins\ServiceDesk\Controllers\InterfaceController@deleteGeneralByIdentifier']);
    });
});
