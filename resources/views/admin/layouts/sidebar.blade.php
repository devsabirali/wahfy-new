
<!--APP-SIDEBAR-->
<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{ route('admin.dashboard') }}">
                <img src="{{ Storage::url(get_logo()) }}" class="header-brand-img desktop-logo" style="width: 150px; " alt="logo">
                <img src="{{ Storage::url(get_logo()) }}" class="header-brand-img toggle-logo" style="width: 150px;" alt="logo">
                <img src="{{ Storage::url(get_logo()) }}" class="header-brand-img light-logo" style="width: 150px;" alt="logo">
                <img src="{{ Storage::url(get_logo()) }}" class="header-brand-img light-logo1" style="width: 150px;" alt="logo">
            </a>
        </div>
        <div class="main-sidemenu">
            <ul class="side-menu">
                <li class="sub-category">
                    <h3>Main</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="side-menu__icon fe fe-home"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <li class="sub-category">
                    <h3>Management</h3>
                </li>

                @if(hasPermissionOrRole('read-users') || hasPermissionOrRole('create-users') || hasPermissionOrRole('read-roles') || hasPermissionOrRole('create-roles') || hasPermissionOrRole('read-permissions') || hasPermissionOrRole('create-permissions'))
                    <li class="slide {{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/permissions*') ? 'is-expanded' : '' }}">
                        <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                            <i class="side-menu__icon fe fe-users"></i>
                            <span class="side-menu__label">Users</span>
                            <i class="angle fe fe-chevron-right"></i>
                        </a>
                        <ul class="slide-menu">
                            @if(hasPermissionOrRole('read-users') || hasPermissionOrRole('create-users'))
                            <li class="sub-slide">
                                <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                    <span class="sub-side-menu__label">Users</span>
                                    <i class="sub-angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="sub-slide-menu">
                                    @if(hasPermissionOrRole('read-users'))
                                    <li><a href="{{ route('admin.users.index') }}" class="sub-slide-item">View Users</a></li>
                                    @endif
                                    @if(hasPermissionOrRole('create-users'))
                                    <li><a href="{{ route('admin.users.create') }}" class="sub-slide-item">Add User</a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                            @if(hasPermissionOrRole('read-roles') || hasPermissionOrRole('create-roles'))
                            <li class="sub-slide">
                                <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                    <span class="sub-side-menu__label">Roles</span>
                                    <i class="sub-angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="sub-slide-menu">
                                    @if(hasPermissionOrRole('read-roles'))
                                    <li><a href="{{ route('admin.roles.index') }}" class="sub-slide-item">View Roles</a></li>
                                    @endif
                                    @if(hasPermissionOrRole('create-roles'))
                                    <li><a href="{{ route('admin.roles.create') }}" class="sub-slide-item">Add Role</a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                            @if(hasPermissionOrRole('read-permissions') || hasPermissionOrRole('create-permissions'))
                            <li class="sub-slide">
                                <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                    <span class="sub-side-menu__label">Permissions</span>
                                    <i class="sub-angle fe fe-chevron-right"></i>
                                </a>
                                <ul class="sub-slide-menu">
                                    @if(hasPermissionOrRole('read-permissions'))
                                    <li><a href="{{ route('admin.permissions.index') }}" class="sub-slide-item">View Permissions</a></li>
                                    @endif
                                    @if(hasPermissionOrRole('create-permissions'))
                                    <li><a href="{{ route('admin.permissions.create') }}" class="sub-slide-item">Add Permission</a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Organization Management -->
               {{--  @if(hasPermissionOrRole(['read-organizations', 'create-organizations'])) --}}
                <li class="slide {{ request()->is('admin/organizations*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-users"></i>
                        <span class="side-menu__label">Organizations</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Organizations</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-organizations'))
                                <li><a href="{{ route('admin.organizations.index') }}" class="sub-slide-item">View Organizations</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-organizations'))
                                <li><a href="{{ route('admin.organizations.create') }}" class="sub-slide-item">Add Organization</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-changeorganizations'))
                                <li><a href="{{ route('admin.organizations.change') }}" class="sub-slide-item">Change Organization</a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </li>
                {{--  @endif --}}
                <!-- Member Management -->
                @if(hasPermissionOrRole(['read-organization_members', 'create-organization_members']))
                <li class="slide {{ request()->is('admin/members*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-user-plus"></i>
                        <span class="side-menu__label">Members</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Members</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-organization_members'))
                                <li><a href="{{ route('admin.members.index') }}" class="sub-slide-item">View Members</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-organization_members'))
                                <!-- <li><a href="{{ route('admin.members.create') }}" class="sub-slide-item">Add Member</a></li> -->
                                @endif
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif
                <!-- Payment Management -->
                @if(hasPermissionOrRole(['read-payments', 'create-payments', 'read-payment_methods', 'create-payment_methods', 'read-payment_histories', 'create-payment_histories', 'read-transactions', 'create-transactions', 'read-charges', 'create-charges', 'read-receipts', 'create-receipts', 'read-payment_reminders', 'create-payment_reminders']))
                <li class="slide {{ request()->is('admin/payments*') || request()->is('admin/payment-methods*') || request()->is('admin/payment-histories*') || request()->is('admin/transactions*') || request()->is('admin/charges*') || request()->is('admin/receipts*') || request()->is('admin/payment-reminders*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-credit-card"></i>
                        <span class="side-menu__label">Payments</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        @if(hasPermissionOrRole(['read-payments', 'create-payments']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Payments</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-payments'))
                                <li><a href="{{ route('admin.payments.index') }}" class="sub-slide-item">View Payments</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-payments'))
                                <li><a href="{{ route('admin.payments.create') }}" class="sub-slide-item">Add Payment</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(hasPermissionOrRole(['read-payment_methods', 'create-payment_methods']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Payment Methods</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-payment_methods'))
                                <li><a href="{{ route('admin.payment-methods.index') }}" class="sub-slide-item">View Methods</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-payment_methods'))
                                <li><a href="{{ route('admin.payment-methods.create') }}" class="sub-slide-item">Add Method</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(hasPermissionOrRole(['read-payment_histories', 'create-payment_histories']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Payment History</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-payment_histories'))
                                <li><a href="{{ route('admin.payment-histories.index') }}" class="sub-slide-item">View History</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-payment_histories'))
                                <li><a href="{{ route('admin.payment-histories.create') }}" class="sub-slide-item">Add History</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(hasPermissionOrRole(['read-transactions', 'create-transactions']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Transactions</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-transactions'))
                                <li><a href="{{ route('admin.transactions.index') }}" class="sub-slide-item">View Transactions</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-transactions'))
                                <li><a href="{{ route('admin.transactions.create') }}" class="sub-slide-item">Add Transaction</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(hasPermissionOrRole(['read-charges', 'create-charges']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Charges</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-charges'))
                                <li><a href="{{ route('admin.charges.index') }}" class="sub-slide-item">View Charges</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-charges'))
                                <li><a href="{{ route('admin.charges.create') }}" class="sub-slide-item">Add Charge</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        {{-- @if(hasPermissionOrRole(['read-receipts', 'create-receipts', 'update-receipts', 'delete-receipts']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Receipts</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-receipts'))
                                <li><a href="{{ route('admin.receipts.index') }}" class="sub-slide-item">View Receipts</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-receipts'))
                                <li><a href="{{ route('admin.receipts.create') }}" class="sub-slide-item">Add Receipt</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(hasPermissionOrRole(['read-payment_reminders', 'create-payment_reminders']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Payment Reminders</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-payment_reminders'))
                                <li><a href="{{ route('admin.payment-reminders.index') }}" class="sub-slide-item">View Reminders</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-payment_reminders'))
                                <li><a href="{{ route('admin.payment-reminders.create') }}" class="sub-slide-item">Add Reminder</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif --}}
                    </ul>
                </li>
                @endif

                <!-- Donation Management -->
                @if(hasPermissionOrRole(['read-donations', 'create-donations']))
                <li class="slide {{ request()->is('admin/donations*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-heart"></i>
                        <span class="side-menu__label">Donations</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Donations</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-donations'))
                                <li><a href="{{ route('admin.donations.index') }}" class="sub-slide-item">View Donations</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-donations'))
                                <li><a href="{{ route('admin.donations.create') }}" class="sub-slide-item">Add Donation</a></li>
                                @endif
                            </ul>
                        </li>
                        @if(hasPermissionOrRole('read-donations'))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Pending Donations</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                <li><a href="{{ route('admin.donations.pending') }}" class="sub-slide-item">View Pending</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                <!-- Event Management -->
                @if(hasPermissionOrRole(['read-incidents', 'create-incidents', 'read-incident_images', 'create-incident_images']))
                <li class="slide {{ request()->is('admin/events*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-alert-triangle"></i>
                        <span class="side-menu__label">Events</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        @if(hasPermissionOrRole(['read-incidents', 'create-incidents']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Healthcare</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-incidents'))
                                <li><a href="{{ route('admin.incidents.healthcare') }}" class="sub-slide-item">View</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-incidents'))
                                <li><a href="{{ route('admin.incidents.create') }}" class="sub-slide-item">Add</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Death</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-incidents'))
                                <li><a href="{{ route('admin.incidents.deceased') }}" class="sub-slide-item">View</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-incidents'))
                                <li><a href="{{ route('admin.incidents.create') }}" class="sub-slide-item">Add</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        {{-- @if(hasAnyPermission(['read-incident_images', 'create-incident_images', 'update-incident_images', 'delete-incident_images']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Event Images</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermission('read-incident_images'))
                                <li><a href="{{ route('admin.incident-images.index') }}" class="sub-slide-item">View Images</a></li>
                                @endif
                                @if(hasPermission('create-incident_images'))
                                <li><a href="{{ route('admin.incident-images.create') }}" class="sub-slide-item">Add Image</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif --}}
                    </ul>
                </li>
                @endif

                <!-- Contribution Management -->
                @if(hasPermissionOrRole(['read-contributions', 'create-contributions']))
                <li class="slide {{ request()->is('admin/contributions*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-dollar-sign"></i>
                        <span class="side-menu__label">Contributions</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Contributions</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-contributions'))
                                <li><a href="{{ route('admin.contributions.index') }}" class="sub-slide-item">View Contributions</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-contributions'))
                                <li><a href="{{ route('admin.contributions.create') }}" class="sub-slide-item">Add Contribution</a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- System Management -->
                @if(hasPermissionOrRole(['read-settings', 'create-settings', 'read-statuses', 'create-statuses', 'read-banners', 'create-banners', 'read-audit_log', 'read-user_activity_log
', 'read-contacts', 'create-contacts']))
                <li class="slide {{ request()->is('admin/settings*') || request()->is('admin/audit-logs*') || request()->is('admin/activity-logs*') || request()->is('admin/statuses*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-settings"></i>
                        <span class="side-menu__label">System</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        @if(hasPermissionOrRole(['read-settings', 'create-settings']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Settings</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-settings'))
                                <li><a href="{{ route('admin.settings.index') }}" class="sub-slide-item">View Settings</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-settings'))
                                <li><a href="{{ route('admin.settings.create') }}" class="sub-slide-item">Add Setting</a></li>
                                @endif
                                @if(hasPermissionOrRole('read-settings'))
                                <li><a href="{{ route('admin.settings.clear-cache') }}" class="sub-slide-item">Clear Cache</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(hasPermissionOrRole(['read-statuses', 'create-statuses']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Status</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-statuses'))
                                <li><a href="{{ route('admin.statuses.index') }}" class="sub-slide-item">View Status</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-statuses'))
                                <li><a href="{{ route('admin.statuses.create') }}" class="sub-slide-item">Add Status</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(hasPermissionOrRole(['read-banners', 'create-banners']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Banners</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-banners'))
                                <li><a href="{{ route('admin.banners.index') }}" class="sub-slide-item">View Banners</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-banners'))
                                <li><a href="{{ route('admin.banners.create') }}" class="sub-slide-item">Add Banner</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(hasPermissionOrRole(['read-audit_log', 'read-user_activity_log']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Logs</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                {{-- @if(hasPermissionOrRole('read-audit_log'))
                                <li><a href="{{ route('admin.audit-logs.index') }}" class="sub-slide-item">Audit Logs</a></li>
                                @endif --}}
                                @if(hasPermissionOrRole('read-user_activity_log'))
                                <li><a href="{{ route('admin.activity-logs.index') }}" class="sub-slide-item">Activity Logs</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(hasPermissionOrRole(['read-contacts', 'create-contacts']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Contact Messages</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-contacts'))
                                <li><a href="{{ route('admin.contacts.index') }}" class="sub-slide-item">View Messages</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                <!-- Blog Management -->
                @if(hasPermissionOrRole(['read-blogs', 'create-blogs', 'read-blog_categories', 'create-blog_categories', 'read-blog_tags', 'create-blog_tags']))
                <li class="slide {{ request()->is('admin/blogs*') || request()->is('admin/blog-categories*') || request()->is('admin/blog-tags*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-file-text"></i>
                        <span class="side-menu__label">Blog Management</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        @if(hasPermissionOrRole(['read-blogs', 'create-blogs']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Blogs</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-blogs'))
                                <li><a href="{{ route('admin.blogs.index') }}" class="sub-slide-item">View Blogs</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-blogs'))
                                <li><a href="{{ route('admin.blogs.create') }}" class="sub-slide-item">Add New Blog</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(hasPermissionOrRole(['read-blog_categories', 'create-blog_categories']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Categories</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-blog_categories'))
                                <li><a href="{{ route('admin.blog-categories.index') }}" class="sub-slide-item">View Categories</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-blog_categories'))
                                <li><a href="{{ route('admin.blog-categories.create') }}" class="sub-slide-item">Add Category</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(hasPermissionOrRole(['read-blog_tags', 'create-blog_tags']))
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Tags</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-blog_tags'))
                                <li><a href="{{ route('admin.blog-tags.index') }}" class="sub-slide-item">View Tags</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-blog_tags'))
                                <li><a href="{{ route('admin.blog-tags.create') }}" class="sub-slide-item">Add Tag</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                <!-- Gallery Management -->
                @if(hasPermissionOrRole(['read-galleries', 'create-galleries']))
                <li class="slide {{ request()->is('admin/gallery*') ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-image"></i>
                        <span class="side-menu__label">Gallery</span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="sub-slide">
                            <a class="sub-side-menu__item" data-bs-toggle="sub-slide" href="javascript:void(0)">
                                <span class="sub-side-menu__label">Gallery</span>
                                <i class="sub-angle fe fe-chevron-right"></i>
                            </a>
                            <ul class="sub-slide-menu">
                                @if(hasPermissionOrRole('read-galleries'))
                                <li><a href="{{ route('admin.gallery.index') }}" class="sub-slide-item">View Gallery</a></li>
                                @endif
                                @if(hasPermissionOrRole('create-galleries'))
                                <li><a href="{{ route('admin.gallery.create') }}" class="sub-slide-item">Add Gallery</a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!--/APP-SIDEBAR-->
