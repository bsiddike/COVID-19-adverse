<?php

use App\Models\Backend\Organization\Enumerator;
use App\Models\Backend\Setting\Permission;
use App\Models\Backend\Setting\Role;
use App\Models\Backend\Setting\User;
use App\Models\Patient;
use App\Models\Symptom;
use App\Models\Vaccine;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(__('menu-sidebar.Home'), route('home'));
});

/****************************************** Http Error ******************************************/

Breadcrumbs::for('frontend.organization.applicants.create', function ($trail) {
    $trail->parent('home');
    $trail->push(__('enumerator.Applicant Registration'), route('frontend.organization.applicants.create'));
});

Breadcrumbs::for('backend', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Admin', route('backend'));
});

Breadcrumbs::for('backend.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('menu-sidebar.Dashboard'), route('backend.dashboard'));
});

/****************************************** Http Error ******************************************/

Breadcrumbs::for('errors.401', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Unauthorized'));
});

Breadcrumbs::for('errors.403', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Forbidden'));
});

Breadcrumbs::for('errors.404', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Page Not Found'));
});

Breadcrumbs::for('errors.419', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push('Page Expired');
});

Breadcrumbs::for('errors.429', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Too Many Requests'));
});

Breadcrumbs::for('errors.500', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Server Error'));
});

Breadcrumbs::for('errors.503', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');
    $trail->push(__('error.Service Unavailable'));
});

/****************************************** Setting ******************************************/

Breadcrumbs::for('backend.settings', function (BreadcrumbTrail $trail) {
    $trail->parent('home');

    $trail->push(__('menu-sidebar.Settings'), route('backend.settings'));
});

/****************************************** User ******************************************/

Breadcrumbs::for('backend.settings.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.settings');

    $trail->push(__('menu-sidebar.Users'), route('backend.settings.users.index'));
});

Breadcrumbs::for('backend.settings.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.settings.users.index');

    $trail->push('Add', route('backend.settings.users.create'));
});

Breadcrumbs::for('backend.settings.users.show', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('backend.settings.users.index');

    $user = ($user instanceof User) ? $user : $user[0];

    $trail->push($user->name, route('backend.settings.users.show', $user->id));
});

Breadcrumbs::for('backend.settings.users.edit', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('backend.settings.users.show', [$user]);

    $trail->push(__('common.Edit'), route('backend.settings.users.edit', $user->id));
});

/****************************************** Permission ******************************************/

Breadcrumbs::for('backend.settings.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.settings');

    $trail->push(__('menu-sidebar.Permissions'), route('backend.settings.permissions.index'));
});

Breadcrumbs::for('backend.settings.permissions.create', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.settings.permissions.index');

    $trail->push(__('common.Add'), route('backend.settings.permissions.create'));
});

Breadcrumbs::for('backend.settings.permissions.show', function (BreadcrumbTrail $trail, $permission) {
    $trail->parent('backend.settings.permissions.index');

    $permission = ($permission instanceof Permission) ? $permission : $permission[0];

    $trail->push($permission->display_name, route('backend.settings.permissions.show', $permission->id));
});

Breadcrumbs::for('backend.settings.permissions.edit', function (BreadcrumbTrail $trail, Permission $permission) {
    $trail->parent('backend.settings.permissions.show', [$permission]);

    $trail->push(__('common.Edit'), route('backend.settings.permissions.edit', $permission->id));
});

/****************************************** Role ******************************************/

Breadcrumbs::for('backend.settings.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.settings');

    $trail->push(__('menu-sidebar.Roles'), route('backend.settings.roles.index'));
});

Breadcrumbs::for('backend.settings.roles.create', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.settings.roles.index');

    $trail->push(__('common.Add'), route('backend.settings.roles.create'));
});

Breadcrumbs::for('backend.settings.roles.show', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('backend.settings.roles.index');

    $role = ($role instanceof Role) ? $role : $role[0];

    $trail->push($role->name, route('backend.settings.roles.show', $role->id));
});

Breadcrumbs::for('backend.settings.roles.edit', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('backend.settings.roles.show', [$role]);

    $trail->push(__('common.Edit'), route('backend.settings.roles.edit', $role->id));
});

/****************************************** Organization ******************************************/

Breadcrumbs::for('backend.organization', function (BreadcrumbTrail $trail) {
    $trail->parent('backend');

    $trail->push(__('menu-sidebar.Organization'), route('backend.organization'));
});

/****************************************** Survey ******************************************/

Breadcrumbs::for('backend.organization.patients.index', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.organization');

    $trail->push('Patients', route('backend.organization.patients.index'));
});

Breadcrumbs::for('backend.organization.patients.hospitalized', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.organization.patients.index');

    $trail->push('Hospitalized', route('backend.organization.patients.hospitalized'));
});

Breadcrumbs::for('backend.organization.patients.recovered', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.organization.patients.index');

    $trail->push('Re-Covid19', route('backend.organization.patients.recovered'));
});

Breadcrumbs::for('backend.organization.patients.died', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.organization.patients.index');

    $trail->push('Died', route('backend.organization.patients.died'));
});

Breadcrumbs::for('backend.organization.patients.create', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.organization.patients.index');

    $trail->push(__('common.Add'), route('backend.organization.patients.create'));
});

Breadcrumbs::for('backend.organization.patients.show', function (BreadcrumbTrail $trail, $patient) {
    $trail->parent('backend.organization.patients.index');

    $patient = ($patient instanceof Patient) ? $patient : $patient[0];

    $trail->push($patient->vaers_id, route('backend.organization.patients.show', $patient->id));
});

Breadcrumbs::for('backend.organization.patients.edit', function (BreadcrumbTrail $trail, Patient $patient) {
    $trail->parent('backend.organization.patients.show', [$patient]);

    $trail->push(__('common.Edit'), route('backend.organization.patients.edit', $patient->id));
});

/****************************************** Enumerator ******************************************/

Breadcrumbs::for('backend.organization.symptoms.index', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.organization');

    $trail->push('Symptoms', route('backend.organization.symptoms.index'));
});

Breadcrumbs::for('backend.organization.symptoms.create', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.organization.symptoms.index');

    $trail->push(__('common.Add'), route('backend.organization.symptoms.create'));
});

Breadcrumbs::for('backend.organization.symptoms.show', function (BreadcrumbTrail $trail, $symptom) {
    $trail->parent('backend.organization.symptoms.index');

    $symptom = ($symptom instanceof Symptom) ? $symptom : $symptom[0];

    $trail->push($symptom->vaers_id, route('backend.organization.symptoms.show', $symptom->id));
});

Breadcrumbs::for('backend.organization.symptoms.edit', function (BreadcrumbTrail $trail, Symptom $symptom) {
    $trail->parent('backend.organization.symptoms.show', [$symptom]);

    $trail->push(__('common.Edit'), route('backend.organization.symptoms.edit', $symptom->id));
});

/****************************************** Enumerator ******************************************/

Breadcrumbs::for('backend.organization.vaccines.index', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.organization');

    $trail->push('Vaccines', route('backend.organization.vaccines.index'));
});

Breadcrumbs::for('backend.organization.vaccines.create', function (BreadcrumbTrail $trail) {
    $trail->parent('backend.organization.vaccines.index');

    $trail->push(__('common.Add'), route('backend.organization.vaccines.create'));
});

Breadcrumbs::for('backend.organization.vaccines.show', function (BreadcrumbTrail $trail, $vaccine) {
    $trail->parent('backend.organization.vaccines.index');

    $vaccine = ($vaccine instanceof Vaccine) ? $vaccine : $vaccine[0];

    $trail->push($vaccine->vax_name, route('backend.organization.vaccines.show', $vaccine->id));
});

Breadcrumbs::for('backend.organization.vaccines.edit', function (BreadcrumbTrail $trail, Vaccine $vaccine) {
    $trail->parent('backend.organization.vaccines.show', [$vaccine]);

    $trail->push(__('common.Edit'), route('backend.organization.vaccines.edit', $vaccine->id));
});

/****************************************** Enumerator ******************************************/
Breadcrumbs::for('frontend.patients.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Patients', route('frontend.patients.index'));
});

Breadcrumbs::for('frontend.patients.show', function (BreadcrumbTrail $trail, Patient $patient) {
    $trail->parent('frontend.patients.index');
    $trail->push('Patient Details', route('frontend.patients.show', $patient->id));
});

Breadcrumbs::for('frontend.patients.apply', function (BreadcrumbTrail $trail) {
    $trail->parent('frontend.patients.index');
    $trail->push('Patient Support', route('frontend.patients.apply'));
});

Breadcrumbs::for('frontend.patients.register', function (BreadcrumbTrail $trail) {
    $trail->parent('frontend.patients.index');
    $trail->push('Patient Support', route('frontend.patients.register'));
});

Breadcrumbs::for('frontend.symptoms.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Symptoms & Outcomes', route('frontend.symptoms.index'));
});

Breadcrumbs::for('frontend.symptoms.show', function (BreadcrumbTrail $trail, Symptom $symptom) {
    $trail->parent('frontend.symptoms.index');
    $trail->push('Symptom Details', route('frontend.symptoms.show'));
});

Breadcrumbs::for('frontend.vaccines.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Vaccines', route('frontend.vaccines.index'));
});

Breadcrumbs::for('frontend.vaccines.show', function (BreadcrumbTrail $trail, Vaccine $vaccine) {
    $trail->parent('frontend.vaccines.index');
    $trail->push('Vaccine Details', route('frontend.vaccines.show'));
});
