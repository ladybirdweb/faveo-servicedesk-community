<?php

if (itilEnabled() == true && !view()->exists('service::assets.index')) {
    Route::group(['prefix' => 'service-desk', 'middleware' => ['web', 'auth']], function () {
        \Event::listen('service.desk.agent.sidebar.replace', function () {
            return 0;
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
            $controller = new App\Itil\Controllers\InterfaceController();
            echo $controller->agentSidebar();
        });

        \Event::listen('service.desk.agent.topbar', function () {
            $controller = new App\Itil\Controllers\InterfaceController();
            echo $controller->agentTopbar();
        });
        \Event::listen('service.desk.agent.topsubbar', function () {
            $controller = new App\Itil\Controllers\InterfaceController();
            echo $controller->agentTopSubbar();
        });

        \Event::listen('service.desk.admin.sidebar', function () {
            $controller = new App\Itil\Controllers\InterfaceController();
            echo $controller->adminSidebar();
        });

        \Event::listen('service.desk.admin.topbar', function () {
            $controller = new App\Itil\Controllers\InterfaceController();
            echo $controller->adminTopbar();
        });
        \Event::listen('service.desk.admin.topsubbar', function () {
            $controller = new App\Itil\Controllers\InterfaceController();
            echo $controller->adminTopSubbar();
        });

        \Event::listen('service.desk.admin.settings', function () {
            $controller = new App\Itil\Controllers\InterfaceController();
            echo $controller->adminSettings();
        });
        \Event::listen('App\Events\TicketDetailTable', function ($event) {
            $controller = new App\Itil\Controllers\InterfaceController();
            echo $controller->ticketDetailTable($event);
        });

        /*
         * Release Managing Module
         */
        Route::get('releases', ['as' => 'service-desk.releases.index', 'uses' => 'App\Itil\Controllers\RelesesController@releasesindex']);
        Route::get('releases/create', ['as' => 'service-desk.releases.create', 'uses' => 'App\Itil\Controllers\RelesesController@releasescreate']);
        Route::post('releases/create', ['as' => 'service-desk.post.releases', 'uses' => 'App\Itil\Controllers\RelesesController@releaseshandleCreate']);
        Route::get('releases/{id}/edit', ['as' => 'service-desk.releases.edit', 'uses' => 'App\Itil\Controllers\RelesesController@releasesedit']);
        Route::patch('releases/{id}', ['as' => 'service-desk.releases.postedit', 'uses' => 'App\Itil\Controllers\RelesesController@releaseshandleEdit']);
        Route::get('releases/{id}/delete', ['as' => 'service-desk.releases.delete', 'uses' => 'App\Itil\Controllers\RelesesController@releasesHandledelete']);
        Route::get('releases/{id}/show', ['as' => 'service-desk.releases.view', 'uses' => 'App\Itil\Controllers\RelesesController@view']);
        Route::get('get-releases', ['as' => 'service-desk.releases.get', 'uses' => 'App\Itil\Controllers\RelesesController@getReleases']);
        Route::get('releases/{id}/complete', ['as' => 'service-desk.releases.view', 'uses' => 'App\Itil\Controllers\RelesesController@complete']);

        /*
         * Changes Managing Module
         */
        Route::get('changes', ['as' => 'service-desk.changes.index', 'uses' => 'App\Itil\Controllers\ChangesController@changesindex']);
        Route::get('changes/create', ['as' => 'service-desk.changes.create', 'uses' => 'App\Itil\Controllers\ChangesController@changescreate']);
        Route::post('changes/create', ['as' => 'service-desk.post.changes', 'uses' => 'App\Itil\Controllers\ChangesController@changeshandleCreate']);
        Route::get('changes/{id}/edit', ['as' => 'service-desk.changes.edit', 'uses' => 'App\Itil\Controllers\ChangesController@changesedit']);
        Route::patch('changes/{id}', ['as' => 'service-desk.changes.postedit', 'uses' => 'App\Itil\Controllers\ChangesController@changeshandleEdit']);
        Route::get('changes/{id}/delete', ['as' => 'service-desk.changes.delete', 'uses' => 'App\Itil\Controllers\ChangesController@changesHandledelete']);
        Route::get('get-changes', ['as' => 'service-desk.changes.get', 'uses' => 'App\Itil\Controllers\ChangesController@getChanges']);
        Route::get('changes/{id}/show', ['as' => 'service-desk.changes.show', 'uses' => 'App\Itil\Controllers\ChangesController@show']);
        Route::get('changes/{id}/close', ['as' => 'change.close', 'uses' => 'App\Itil\Controllers\ChangesController@close']);
        Route::post('changes/release/{id}', ['as' => 'change.release.post', 'uses' => 'App\Itil\Controllers\ChangesController@attachNewRelease']);
        Route::get('changes/release', ['as' => 'change.release', 'uses' => 'App\Itil\Controllers\ChangesController@getReleases']);
        Route::post('changes/release/attach/{id}', ['as' => 'change.release.attach', 'uses' => 'App\Itil\Controllers\ChangesController@attachExistingRelease']);
        Route::get('changes/{changeid}/detach', ['as' => 'change.release.detach', 'uses' => 'App\Itil\Controllers\ChangesController@detachRelease']);

        /*
         * Problem Managing Module
         */
        Route::get('problems', ['as' => 'service-desk.problem.index', 'uses' => 'App\Itil\Controllers\ProblemController@index']);
        Route::get('problem/create', ['as' => 'service-desk.problem.create', 'uses' => 'App\Itil\Controllers\ProblemController@create']);
        Route::post('problem/create', ['as' => 'service-desk.problem.postcreate', 'uses' => 'App\Itil\Controllers\ProblemController@handleCreate']);
        Route::get('problem/{id}/edit', ['as' => 'service-desk.problem.edit', 'uses' => 'App\Itil\Controllers\ProblemController@edit']);
        Route::patch('problem/{id}', ['as' => 'service-desk.problem.postedit', 'uses' => 'App\Itil\Controllers\ProblemController@handleEdit']);
        Route::get('problem/{id}/delete', ['as' => 'service-desk.problem.postdelete', 'uses' => 'App\Itil\Controllers\ProblemController@delete']);
        Route::get('get-problems', ['as' => 'service-desk.problem.get', 'uses' => 'App\Itil\Controllers\ProblemController@getproblems']);
        Route::post('attach-problem/ticket/new', ['as' => 'attach.problem.ticket.new', 'uses' => 'App\Itil\Controllers\ProblemController@attachNewProblemToTicket']);
        Route::post('attach-problem/ticket/existing', ['as' => 'attach.problem.ticket.existing', 'uses' => 'App\Itil\Controllers\ProblemController@attachExistingProblemToTicket']);
        Route::get('problems/attach/existing', ['as' => 'attach.problem.ticket.existing.ajax', 'uses' => 'App\Itil\Controllers\ProblemController@getAttachableProblem']);
        Route::get('problem/detach/{ticketid}/{probid}', ['as' => 'detach.problem.ticket', 'uses' => 'App\Itil\Controllers\ProblemController@detach']);
        Route::get('problem/{id}/show', ['as' => 'show.problem', 'uses' => 'App\Itil\Controllers\ProblemController@show']);
        Route::get('problem/{id}/close', ['as' => 'problem.close', 'uses' => 'App\Itil\Controllers\ProblemController@close']);
        Route::post('problem/change/{id}', ['as' => 'problem.change.post', 'uses' => 'App\Itil\Controllers\ProblemController@attachNewChange']);
        Route::get('problem/change', ['as' => 'problem.change', 'uses' => 'App\Itil\Controllers\ProblemController@getChanges']);
        Route::post('problem/change/attach/{id}', ['as' => 'problem.change.attach', 'uses' => 'App\Itil\Controllers\ProblemController@attachExistingChange']);
        Route::get('problem/{problemid}/detach', ['as' => 'problem.change.detach', 'uses' => 'App\Itil\Controllers\ProblemController@detachChange']);

        /*
         * Location Catagory Managing Module
         */
        Route::get('location-category-types', ['as' => 'service-desk.location-category.index', 'uses' => 'App\Itil\Controllers\LocationCategoryController@index']);
        Route::get('location-category-types/create', ['as' => 'service-desk.location-category.create', 'uses' => 'App\Itil\Controllers\LocationCategoryController@create']);
        Route::post('location-category-types/create', ['as' => 'service-desk.post.location-category', 'uses' => 'App\Itil\Controllers\LocationCategoryController@handleCreate']);
        Route::get('location-category-types/{id}/edit', ['as' => 'service-desk.location-category.edit', 'uses' => 'App\Itil\Controllers\LocationCategoryController@edit']);
        Route::patch('location-category-types/{id}', ['as' => 'service-desk.location-category.postedit', 'uses' => 'App\Itil\Controllers\LocationCategoryController@handleEdit']);
        Route::get('location-category-types/{id}/delete', ['as' => 'service-desk.location-category.delet', 'uses' => 'App\Itil\Controllers\LocationCategoryController@handledelete']);
        Route::get('get-location-category-types', ['as' => 'service-desk.location-category.get', 'uses' => 'App\Itil\Controllers\LocationCategoryController@getLocation']);

        /*
         * Location Managing Module
         */
        Route::get('location-types', ['as' => 'service-desk.location.index', 'uses' => 'App\Itil\Controllers\LocationController@index']);
        Route::get('location-types/create', ['as' => 'service-desk.location.create', 'uses' => 'App\Itil\Controllers\LocationController@create']);
        Route::post('location-types/create1', ['as' => 'service-desk.post.location', 'uses' => 'App\Itil\Controllers\LocationController@handleCreate']);
        Route::get('location-types/{id}/edit', ['as' => 'service-desk.location.edit', 'uses' => 'App\Itil\Controllers\LocationController@edit']);
        Route::post('location-types/postedit1', ['as' => 'service-desk.location.postedit', 'uses' => 'App\Itil\Controllers\LocationController@handleEdit']);
        Route::get('location-types/{id}/delete', ['as' => 'service-desk.location.delete', 'uses' => 'App\Itil\Controllers\LocationController@handledelete']);
        Route::get('get-location-types', ['as' => 'service-desk.location.get', 'uses' => 'App\Itil\Controllers\LocationController@getLocation']);
        Route::get('location-types/{id}/show', ['as' => 'service-desk.location.show', 'uses' => 'App\Itil\Controllers\LocationController@show']);
        Route::get('location/org', ['as' => 'org.location', 'uses' => 'App\Itil\Controllers\LocationController@getLocationsForForm']);

        /*
         * Cab
         */
        Route::resource('cabs', 'App\Itil\Controllers\CabController');
        Route::get('cab/get-cab', ['as' => 'cabs.get.ajax', 'uses' => 'App\Itil\Controllers\CabController@getCab']);
        Route::get('cabs/vote/{cabid}/{owner}', ['as' => 'cabs.get.vote', 'uses' => 'App\Itil\Controllers\CabController@vote']);
        Route::post('cabs/vote/{cabid}/{owner}', ['as' => 'cabs.post.vote', 'uses' => 'App\Itil\Controllers\CabController@postVote']);
        Route::get('cabs/{cabid}/{owner}/show', ['as' => 'cabs.vote.show', 'uses' => 'App\Itil\Controllers\CabController@showVotes']);

        /*
         * Common
         */
        Route::get('cabs/{cabid}/{owner}/show', ['as' => 'cabs.vote.show', 'uses' => 'App\Itil\Controllers\CabController@showVotes']);
        Route::post('general/{id}/{table}', ['as' => 'general.post', 'uses' => 'App\Itil\Controllers\InterfaceController@generalInfo']);
        Route::get('delete/{attachid}/{owner}/attachment', ['as' => 'attach.delete', 'uses' => 'App\Itil\Controllers\InterfaceController@deleteAttachments']);
        Route::get('download/{attachid}/{owner}/attachment', ['as' => 'attach.delete', 'uses' => 'App\Itil\Controllers\InterfaceController@downloadAttachments']);
        Route::get('general/{owner}/{identifier}/delete', ['as' => 'attach.delete', 'uses' => 'App\Itil\Controllers\InterfaceController@deleteGeneralByIdentifier']);
    });
}
