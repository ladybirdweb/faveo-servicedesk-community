<?php

/**
 * Products.
 */
if (!Breadcrumbs::exists('service-desk.products.index')) {
    Breadcrumbs::register('service-desk.products.index', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Products', route('service-desk.products.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.products.create')) {
    Breadcrumbs::register('service-desk.products.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.products.index');
        $breadcrumbs->push('Create', route('service-desk.products.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.products.edit')) {
    Breadcrumbs::register('service-desk.products.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.products.index');
        $breadcrumbs->push('Edit', route('service-desk.products.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.products.show')) {
    Breadcrumbs::register('service-desk.products.show', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.products.index');
        $breadcrumbs->push('Show', route('service-desk.products.show', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.contract.index')) {

    /*
     * Contract
     */
    Breadcrumbs::register('service-desk.contract.index', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Contracts', route('service-desk.contract.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.contract.create')) {
    Breadcrumbs::register('service-desk.contract.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.contract.index');
        $breadcrumbs->push('Create', route('service-desk.contract.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.contract.edit')) {
    Breadcrumbs::register('service-desk.contract.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.contract.index');
        $breadcrumbs->push('Edit', route('service-desk.contract.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.contract.show')) {
    Breadcrumbs::register('service-desk.contract.show', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.contract.index');
        $breadcrumbs->push('Show', route('service-desk.contract.show', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.vendor.index')) {

    /*
     * Vendor
     */
    Breadcrumbs::register('service-desk.vendor.index', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Vendor', route('service-desk.vendor.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.vendor.create')) {
    Breadcrumbs::register('service-desk.vendor.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.vendor.index');
        $breadcrumbs->push('Create', route('service-desk.vendor.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.vendor.edit')) {
    Breadcrumbs::register('service-desk.vendor.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.vendor.index');
        $breadcrumbs->push('Edit', route('service-desk.vendor.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.vendor.show')) {
    Breadcrumbs::register('service-desk.vendor.show', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.vendor.index');
        $breadcrumbs->push('Show', route('service-desk.vendor.show', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.assetstypes.index')) {

    /*
     * Asset Type
     */
    Breadcrumbs::register('service-desk.assetstypes.index', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Asset Types', route('service-desk.assetstypes.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.assetstypes.create')) {
    Breadcrumbs::register('service-desk.assetstypes.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.assetstypes.index');
        $breadcrumbs->push('Create', route('service-desk.assetstypes.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.assetstypes.edit')) {
    Breadcrumbs::register('service-desk.assetstypes.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.assetstypes.index');
        $breadcrumbs->push('Create', route('service-desk.assetstypes.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.contractstypes.index')) {

    /*
     * Contract Type
     */
    Breadcrumbs::register('service-desk.contractstypes.index', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Contract Types', route('service-desk.contractstypes.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.contractstypes.create')) {
    Breadcrumbs::register('service-desk.contractstypes.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.contractstypes.index');
        $breadcrumbs->push('Create', route('service-desk.contractstypes.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.contractstypes.edit')) {
    Breadcrumbs::register('service-desk.contractstypes.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.contractstypes.index');
        $breadcrumbs->push('Edit', route('service-desk.contractstypes.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.licensetypes.index')) {

    /*
     * License Type
     */
    Breadcrumbs::register('service-desk.licensetypes.index', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('License Types', route('service-desk.contractstypes.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.licensetypes.create')) {
    Breadcrumbs::register('service-desk.licensetypes.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.licensetypes.index');
        $breadcrumbs->push('Create', route('service-desk.licensetypes.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.licensetypes.edit')) {
    Breadcrumbs::register('service-desk.licensetypes.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.licensetypes.index');
        $breadcrumbs->push('Edit', route('service-desk.licensetypes.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.location-category.index')) {

    /*
     * Location Category
     */
    Breadcrumbs::register('service-desk.location-category.index', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Location Category', route('service-desk.location-category.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.location-category.create')) {
    Breadcrumbs::register('service-desk.location-category.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.location-category.index');
        $breadcrumbs->push('Create', route('service-desk.location-category.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.location-category.edit')) {
    Breadcrumbs::register('service-desk.location-category.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.location-category.index');
        $breadcrumbs->push('Edit', route('service-desk.location-category.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.location.index')) {

    /*
     * Location
     */
    Breadcrumbs::register('service-desk.location.index', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Location', route('service-desk.location.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.location.create')) {
    Breadcrumbs::register('service-desk.location.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.location.index');
        $breadcrumbs->push('Create', route('service-desk.location.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.location.edit')) {
    Breadcrumbs::register('service-desk.location.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.location.index');
        $breadcrumbs->push('Edit', route('service-desk.location.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.location.show')) {
    Breadcrumbs::register('service-desk.location.show', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.location.index');
        $breadcrumbs->push('Show', route('service-desk.location.show', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.procurment.index')) {

    /*
     * Product Procurement
     */
    Breadcrumbs::register('service-desk.procurment.index', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Product Procurement', route('service-desk.procurment.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.procurment.create')) {
    Breadcrumbs::register('service-desk.procurment.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.procurment.index');
        $breadcrumbs->push('Create', route('service-desk.procurment.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.procurment.edit')) {
    Breadcrumbs::register('service-desk.procurment.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.procurment.index');
        $breadcrumbs->push('Edit', route('service-desk.procurment.edit', $id));
    });
}
if (!Breadcrumbs::exists('form.builder.index')) {
    /*
     * Form Builder
     */
    Breadcrumbs::register('form.builder.index', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Form Builder', route('form.builder.index'));
    });
}
if (!Breadcrumbs::exists('form.builder.create')) {
    Breadcrumbs::register('form.builder.create', function ($breadcrumbs) {
        $breadcrumbs->parent('form.builder.index');
        $breadcrumbs->push('Create', route('form.builder.create'));
    });
}
if (!Breadcrumbs::exists('form.builder.edit')) {
    Breadcrumbs::register('form.builder.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('form.builder.index');
        $breadcrumbs->push('Edit', route('form.builder.edit', $id));
    });
}
if (!Breadcrumbs::exists('form.builder.show')) {
    Breadcrumbs::register('form.builder.show', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('form.builder.index');
        $breadcrumbs->push('Edit', route('form.builder.show', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.cabs.index')) {

    /*
     * Cab
     */
    Breadcrumbs::register('service-desk.cabs.index', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('CAB', route('service-desk.cabs.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.cabs.create')) {
    Breadcrumbs::register('service-desk.cabs.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.cabs.index');
        $breadcrumbs->push('Create', route('service-desk.cabs.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.cabs.edit')) {
    Breadcrumbs::register('service-desk.cabs.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.cabs.index');
        $breadcrumbs->push('Edit', route('service-desk.cabs.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.asset.index')) {

    /*
     * Assets
     */
    Breadcrumbs::register('service-desk.asset.index', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Assets', route('service-desk.asset.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.asset.create')) {
    Breadcrumbs::register('service-desk.asset.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.asset.index');
        $breadcrumbs->push('Create', route('service-desk.asset.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.asset.edit')) {
    Breadcrumbs::register('service-desk.asset.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.asset.index');
        $breadcrumbs->push('Edit', route('service-desk.asset.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.asset.show')) {
    Breadcrumbs::register('service-desk.asset.show', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.asset.index');
        $breadcrumbs->push('Show', route('service-desk.asset.show', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.releases.index')) {

    /*
     * Release
     */
    Breadcrumbs::register('service-desk.releases.index', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Release', route('service-desk.releases.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.releases.create')) {
    Breadcrumbs::register('service-desk.releases.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.releases.index');
        $breadcrumbs->push('Create', route('service-desk.releases.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.releases.edit')) {
    Breadcrumbs::register('service-desk.releases.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.releases.index');
        $breadcrumbs->push('Edit', route('service-desk.releases.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.releases.show')) {
    Breadcrumbs::register('service-desk.releases.show', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.releases.index');
        $breadcrumbs->push('Show', route('service-desk.releases.show', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.changes.index')) {

    /*
     * Change
     */
    Breadcrumbs::register('service-desk.changes.index', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Change', route('service-desk.changes.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.changes.create')) {
    Breadcrumbs::register('service-desk.changes.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.changes.index');
        $breadcrumbs->push('Create', route('service-desk.changes.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.changes.edit')) {
    Breadcrumbs::register('service-desk.changes.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.changes.index');
        $breadcrumbs->push('Edit', route('service-desk.changes.edit', $id));
    });
}
if (!Breadcrumbs::exists('service-desk.changes.show')) {
    Breadcrumbs::register('service-desk.changes.show', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.changes.index');
        $breadcrumbs->push('Show', route('service-desk.changes.show', $id));
    });
}
/*
 * Problems
 */
if (!Breadcrumbs::exists('service-desk.problem.index')) {
    Breadcrumbs::register('service-desk.problem.index', function ($breadcrumbs) {
        $breadcrumbs->parent('dashboard');
        $breadcrumbs->push('Problem', route('service-desk.problem.index'));
    });
}
if (!Breadcrumbs::exists('service-desk.problem.create')) {
    Breadcrumbs::register('service-desk.problem.create', function ($breadcrumbs) {
        $breadcrumbs->parent('service-desk.problem.index');
        $breadcrumbs->push('Create', route('service-desk.problem.create'));
    });
}
if (!Breadcrumbs::exists('service-desk.problem.edit')) {
    Breadcrumbs::register('service-desk.problem.edit', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.problem.index');
        $breadcrumbs->push('Edit', route('service-desk.problem.edit', $id));
    });
}
if (!Breadcrumbs::exists('show.problem')) {
    Breadcrumbs::register('show.problem', function ($breadcrumbs, $id) {
        $breadcrumbs->parent('service-desk.problem.index');
        $breadcrumbs->push('Show', route('show.problem', $id));
    });
}

/*
 * Announcement
 */
if (!Breadcrumbs::exists('announcement')) {
    Breadcrumbs::register('announcement', function ($breadcrumbs) {
        $breadcrumbs->parent('setting');
        $breadcrumbs->push('Announcement', route('announcement'));
    });
}
