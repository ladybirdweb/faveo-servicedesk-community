<?php

/**
 * Release.
 */
Breadcrumbs::register('service-desk.releases.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Release', route('service-desk.releases.index'));
});
Breadcrumbs::register('service-desk.releases.create', function ($breadcrumbs) {
    $breadcrumbs->parent('service-desk.releases.index');
    $breadcrumbs->push('Create', route('service-desk.releases.create'));
});

Breadcrumbs::register('service-desk.releases.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('service-desk.releases.index');
    $breadcrumbs->push('Edit', route('service-desk.releases.edit', $id));
});
Breadcrumbs::register('service-desk.releases.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('service-desk.releases.index');
    $breadcrumbs->push('Show', route('service-desk.releases.show', $id));
});

/*
 * Change
 */
Breadcrumbs::register('service-desk.changes.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Change', route('service-desk.changes.index'));
});
Breadcrumbs::register('service-desk.changes.create', function ($breadcrumbs) {
    $breadcrumbs->parent('service-desk.changes.index');
    $breadcrumbs->push('Create', route('service-desk.changes.create'));
});

Breadcrumbs::register('service-desk.changes.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('service-desk.changes.index');
    $breadcrumbs->push('Edit', route('service-desk.changes.edit', $id));
});
Breadcrumbs::register('service-desk.changes.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('service-desk.changes.index');
    $breadcrumbs->push('Show', route('service-desk.changes.show', $id));
});

/*
 * Problems
 */
Breadcrumbs::register('service-desk.problem.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Problem', route('service-desk.problem.index'));
});
Breadcrumbs::register('service-desk.problem.create', function ($breadcrumbs) {
    $breadcrumbs->parent('service-desk.problem.index');
    $breadcrumbs->push('Create', route('service-desk.problem.create'));
});

Breadcrumbs::register('service-desk.problem.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('service-desk.problem.index');
    $breadcrumbs->push('Edit', route('service-desk.problem.edit', $id));
});
Breadcrumbs::register('show.problem', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('service-desk.problem.index');
    $breadcrumbs->push('Show', route('show.problem', $id));
});

/*
 * Location Category
 */
Breadcrumbs::register('service-desk.location-category.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('Location Category', route('service-desk.location-category.index'));
});
Breadcrumbs::register('service-desk.location-category.create', function ($breadcrumbs) {
    $breadcrumbs->parent('service-desk.location-category.index');
    $breadcrumbs->push('Create', route('service-desk.location-category.create'));
});

Breadcrumbs::register('service-desk.location-category.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('service-desk.location-category.index');
    $breadcrumbs->push('Edit', route('service-desk.location-category.edit', $id));
});

/*
 * Location
 */
Breadcrumbs::register('service-desk.location.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('Location', route('service-desk.location.index'));
});
Breadcrumbs::register('service-desk.location.create', function ($breadcrumbs) {
    $breadcrumbs->parent('service-desk.location.index');
    $breadcrumbs->push('Create', route('service-desk.location.create'));
});

Breadcrumbs::register('service-desk.location.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('service-desk.location.index');
    $breadcrumbs->push('Edit', route('service-desk.location.edit', $id));
});
Breadcrumbs::register('service-desk.location.show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('service-desk.location.index');
    $breadcrumbs->push('Show', route('service-desk.location.show', $id));
});
/*
 * Cab
 */
Breadcrumbs::register('service-desk.cabs.index', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('CAB', route('service-desk.cabs.index'));
});
Breadcrumbs::register('service-desk.cabs.create', function ($breadcrumbs) {
    $breadcrumbs->parent('service-desk.cabs.index');
    $breadcrumbs->push('Create', route('service-desk.cabs.create'));
});

Breadcrumbs::register('service-desk.cabs.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('service-desk.cabs.index');
    $breadcrumbs->push('Edit', route('service-desk.cabs.edit', $id));
});
