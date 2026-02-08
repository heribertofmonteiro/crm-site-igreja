<?php

use Illuminate\Support\Facades\Route;

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Igreja On Line',
    'title_prefix' => '',
    'title_postfix' => ' | Sistema de Gestão Eclesiástica',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 800; font-size: 1.3rem; letter-spacing: 1px; text-shadow: none;">Igreja On Line</span>',
    'logo_img' => null,
    'logo_img_class' => '',
    'logo_img_xl' => null,
    'logo_img_xl_class' => '',
    'logo_img_alt' => 'Igreja On Line',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => null,
            'alt' => 'Igreja On Line',
            'effect' => 'animation__fadeIn',
            'width' => 200,
            'height' => 60,
            'text' => '<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 15px;"><div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);"><i class="fas fa-church" style="font-size: 28px; color: white;"></i></div><span style="font-size: 1.8rem; font-weight: 800; background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; letter-spacing: 2px; text-shadow: none;">Igreja On Line</span></div>',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => '/',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => false,
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        ['header' => 'GOVERNANÇA E DIREÇÃO'],
        [
            'text' => 'Conselho Pastoral',
            'route' => 'pastoral.councils.index',
            'icon' => 'fas fa-church',
            'can' => 'governanca_pastoral.view',
        ],
        [
            'text' => 'Notas Pastorais',
            'route' => 'pastoral.notes.index',
            'icon' => 'fas fa-book',
            'can' => 'governanca_pastoral.view',
        ],
        [
            'text' => 'Doutrinas',
            'route' => 'pastoral.doctrines.index',
            'icon' => 'fas fa-bible',
            'can' => 'governanca_pastoral.view',
        ],
        ['header' => 'ADMINISTRAÇÃO GERAL'],
        [
            'text' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'fas fa-tachometer-alt',
        ],
        [
            'text' => 'Membros',
            'route' => 'admin.members.index',
            'icon' => 'fas fa-users',
            'can' => 'administracao_geral.view',
        ],
        [
            'text' => 'Eventos da Igreja',
            'route' => 'admin.events.index',
            'icon' => 'fas fa-calendar',
            'can' => 'administracao_geral.view',
        ],
        [
            'text' => 'Documentos',
            'route' => 'admin.administration.documents.index',
            'icon' => 'fas fa-file-alt',
            'can' => 'administracao_geral.view',
        ],
        [
            'text' => 'Departamentos',
            'route' => 'admin.administration.departments.index',
            'icon' => 'fas fa-building',
            'can' => 'administracao_geral.view',
        ],
        [
            'text' => 'Anúncios',
            'route' => 'admin.administration.announcements.index',
            'icon' => 'fas fa-bullhorn',
            'can' => 'administracao_geral.view',
        ],
        [
            'text' => 'Documentos Institucionais',
            'route' => 'admin.administration.documents.index',
            'icon' => 'fas fa-folder-open',
            'can' => 'administracao_geral.view',
        ],
        [
            'text' => 'Atas de Reunião',
            'route' => 'admin.administration.meeting-minutes.index',
            'icon' => 'fas fa-file-signature',
            'can' => 'administracao_geral.view',
        ],
        ['header' => 'GESTÃO DE PESSOAS'],
        [
            'text' => 'Usuários',
            'route' => 'admin.users.index',
            'icon' => 'fas fa-user-cog',
            'can' => 'gestao_pessoas_lideranca.view',
        ],
        [
            'text' => 'Funções de Voluntários',
            'route' => 'admin.volunteer_roles.index',
            'icon' => 'fas fa-id-badge',
            'can' => 'gestao_pessoas_lideranca.view',
        ],
        [
            'text' => 'Escalas de Voluntários',
            'route' => 'admin.volunteer_schedules.index',
            'icon' => 'fas fa-calendar-check',
            'can' => 'gestao_pessoas_lideranca.view',
        ],
        ['header' => 'LOUVOR E ADORAÇÃO'],
        [
            'text' => 'Músicas',
            'route' => 'admin.worship.songs.index',
            'icon' => 'fas fa-music',
            'can' => 'ministerios_atividades.view',
        ],
        [
            'text' => 'Setlists',
            'route' => 'admin.worship.setlists.index',
            'icon' => 'fas fa-list-ol',
            'can' => 'ministerios_atividades.view',
        ],
        [
            'text' => 'Equipes',
            'route' => 'admin.worship.teams.index',
            'icon' => 'fas fa-users-cog',
            'can' => 'ministerios_atividades.view',
        ],
        [
            'text' => 'Ensaios',
            'route' => 'admin.worship.rehearsals.index',
            'icon' => 'fas fa-microphone',
            'can' => 'ministerios_atividades.view',
        ],
        ['header' => 'EDUCAÇÃO CRISTÃ'],
        [
            'text' => 'Classes',
            'route' => 'education.classes.index',
            'icon' => 'fas fa-chalkboard-teacher',
            'can' => 'ministerios_atividades.view',
        ],
        [
            'text' => 'Materiais Didáticos',
            'route' => 'education.materials.index',
            'icon' => 'fas fa-book-open',
            'can' => 'ministerios_atividades.view',
        ],
        [
            'text' => 'Alunos',
            'route' => 'education.students.index',
            'icon' => 'fas fa-user-graduate',
            'can' => 'ministerios_atividades.view',
        ],
        ['header' => 'FINANCEIRO'],
        [
            'text' => 'Contas Financeiras',
            'route' => 'admin.finance.accounts.index',
            'icon' => 'fas fa-university',
            'can' => 'gestao_financeira.view',
        ],
        [
            'text' => 'Transações',
            'route' => 'admin.finance.transactions.index',
            'icon' => 'fas fa-exchange-alt',
            'can' => 'gestao_financeira.view',
        ],
        [
            'text' => 'Categorias de Transação',
            'route' => 'admin.finance.transaction_categories.index',
            'icon' => 'fas fa-tags',
            'can' => 'gestao_financeira.view',
        ],
        [
            'text' => 'Orçamentos',
            'route' => 'admin.finance.budgets.index',
            'icon' => 'fas fa-chart-pie',
            'can' => 'gestao_financeira.view',
        ],
        [
            'text' => 'Doações',
            'route' => 'admin.donations.index',
            'icon' => 'fas fa-hand-holding-heart',
            'can' => 'gestao_financeira.view',
        ],
        [
            'text' => 'Auditorias Financeiras',
            'route' => 'financial-audits.index',
            'icon' => 'fas fa-search-dollar',
            'can' => 'gestao_financeira.view',
        ],
        [
            'text' => 'Conselho Fiscal',
            'route' => 'fiscal-council-meetings.index',
            'icon' => 'fas fa-balance-scale',
            'can' => 'gestao_financeira.view',
        ],
        ['header' => 'MISSÕES'],
        [
            'text' => 'Missionários',
            'route' => 'missions.missionaries.index',
            'icon' => 'fas fa-cross',
            'can' => 'ministerios_atividades.view',
        ],
        [
            'text' => 'Projetos Missionários',
            'route' => 'missions.projects.index',
            'icon' => 'fas fa-globe-americas',
            'can' => 'ministerios_atividades.view',
        ],
        [
            'text' => 'Apoios Missionários',
            'route' => 'missions.supports.index',
            'icon' => 'fas fa-hands-helping',
            'can' => 'ministerios_atividades.view',
        ],
        ['header' => 'PATRIMÔNIO'],
        [
            'text' => 'Ativos',
            'route' => 'patrimony.assets.index',
            'icon' => 'fas fa-boxes',
            'can' => 'patrimonio_infraestrutura.view',
        ],
        [
            'text' => 'Ordens de Manutenção',
            'route' => 'patrimony.maintenance_orders.index',
            'icon' => 'fas fa-tools',
            'can' => 'patrimonio_infraestrutura.view',
        ],
        [
            'text' => 'Agendamento de Espaços',
            'route' => 'patrimony.space_bookings.index',
            'icon' => 'fas fa-door-open',
            'can' => 'patrimonio_infraestrutura.view',
        ],
        ['header' => 'MÍDIA E COMUNICAÇÃO'],
        [
            'text' => 'Mídia',
            'route' => 'admin.media.index',
            'icon' => 'fas fa-photo-video',
            'can' => 'comunicacao_evangelismo.view',
        ],
        [
            'text' => 'Categorias de Mídia',
            'route' => 'admin.media.categories.index',
            'icon' => 'fas fa-folder',
            'can' => 'comunicacao_evangelismo.view',
        ],
        [
            'text' => 'Playlists',
            'route' => 'admin.media.playlists.index',
            'icon' => 'fas fa-list',
            'can' => 'comunicacao_evangelismo.view',
        ],
        [
            'text' => 'Transmissões ao Vivo',
            'route' => 'admin.media.livestreams.index',
            'icon' => 'fas fa-satellite-dish',
            'can' => 'comunicacao_evangelismo.view',
        ],
        [
            'text' => 'Posts nas Redes',
            'route' => 'admin.media.index',
            'icon' => 'fab fa-facebook',
            'can' => 'comunicacao_evangelismo.view',
        ],
        ['header' => 'AÇÃO SOCIAL'],
        [
            'text' => 'Projetos Sociais',
            'route' => 'social.projects.index',
            'icon' => 'fas fa-hands-helping',
            'can' => 'acao_social_diaconia.view',
        ],
        [
            'text' => 'Voluntários Sociais',
            'route' => 'social.volunteers.index',
            'icon' => 'fas fa-users',
            'can' => 'acao_social_diaconia.view',
        ],
        [
            'text' => 'Assistência Social',
            'route' => 'social.assistance.index',
            'icon' => 'fas fa-heart',
            'can' => 'acao_social_diaconia.view',
        ],
        ['header' => 'JURÍDICO E COMPLIANCE'],
        [
            'text' => 'Documentos Legais',
            'route' => 'admin.legal.legal_documents.index',
            'icon' => 'fas fa-gavel',
            'can' => 'juridico_compliance.view',
        ],
        [
            'text' => 'LGPD',
            'route' => 'admin.legal.lgpd_consents.index',
            'icon' => 'fas fa-user-shield',
            'can' => 'juridico_compliance.view',
        ],
        [
            'text' => 'Obrigações de Compliance',
            'route' => 'admin.legal.compliance_obligations.index',
            'icon' => 'fas fa-clipboard-check',
            'can' => 'juridico_compliance.view',
        ],
        ['header' => 'TECNOLOGIA'],
        [
            'text' => 'Infraestrutura',
            'route' => 'it.infrastructure.index',
            'icon' => 'fas fa-server',
            'can' => 'tecnologia_informacao.view',
        ],
        [
            'text' => 'Incidentes de Segurança',
            'route' => 'it.security.index',
            'icon' => 'fas fa-shield-alt',
            'can' => 'tecnologia_informacao.view',
        ],
        ['header' => 'SISTEMA'],
        [
            'text' => 'Logs de Auditoria',
            'route' => 'logs.audits',
            'icon' => 'fas fa-clipboard-list',
            'can' => 'admin.view',
        ],
        [
            'text' => 'Incidentes',
            'route' => 'logs.incidents',
            'icon' => 'fas fa-exclamation-triangle',
            'can' => 'admin.view',
        ],
        [
            'text' => 'Qualidade de Código',
            'route' => 'qualidade.scan',
            'icon' => 'fas fa-code',
            'can' => 'admin.view',
        ],
        [
            'text' => 'Configurações',
            'route' => 'admin.settings.index',
            'icon' => 'fas fa-cogs',
            'can' => 'admin.view',
        ],
        ['header' => 'EXPANSÃO'],
        [
            'text' => 'Plantação de Igrejas',
            'route' => 'expansion.plans.index',
            'icon' => 'fas fa-church',
            'can' => 'governanca_pastoral.view',
        ],
        ['header' => 'CONTA'],
        [
            'text' => 'Conta',
            'route' => 'profile.edit',
            'icon' => 'fas fa-user-circle',
            'can' => 'conta.view',
        ],
        [
            'text' => 'Perfil',
            'route' => 'profile.edit',
            'icon' => 'fas fa-fw fa-user',
            'can' => 'perfil.view',
        ],
        [
            'text' => 'Alterar Senha',
            'route' => 'profile.edit',
            'icon' => 'fas fa-fw fa-lock',
            'can' => 'password.view',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
