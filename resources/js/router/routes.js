import store from '../store';

// Layouts
const ProfileLayout = () => import(/* webpackChunkName: "profile" */ '../components/layouts/ProfileLayout');
const SettingsLayout = () => import(/* webpackChunkName: "settings" */ '../components/layouts/SettingsLayout');
const FilemanagerLayout = () => import(/* webpackChunkName: "filemanager" */ '../util/filemanager/components/Tool');

// Auth Pages
const Login = () => import(/* webpackChunkName: "auth" */ '../components/pages/Login');
const Register = () => import(/* webpackChunkName: "auth" */ '../components/pages/Register');

// Profile
const Profile = () => import(/* webpackChunkName: "profile" */ '../components/pages/Profile');
const ProfilePhotos = () => import(/* webpackChunkName: "profile" */ '../components/pages/profile/ProfilePhotos');
const ProfileVideos = () => import(/* webpackChunkName: "profile" */ '../components/pages/profile/ProfileVideos');
const ProfileNews = () => import(/* webpackChunkName: "profile" */ '../components/pages/profile/ProfileNews');
const ProfileFriends = () => import(/* webpackChunkName: "profile" */ '../components/pages/profile/ProfileFriends');
const ProfilePages = () => import(/* webpackChunkName: "profile" */ '../components/pages/profile/ProfilePages');
const ProfileGroups = () => import(/* webpackChunkName: "profile" */ '../components/pages/profile/ProfileGroups');
const ProfileNurseries = () => import(/* webpackChunkName: "profile" */ '../components/pages/profile/ProfileNurseries');
const ProfileAnnouncements = () => import(/* webpackChunkName: "profile" */ '../components/pages/profile/ProfileAnnouncements');
const ProfilePromote = () => import(/* webpackChunkName: "profile" */ '../components/pages/profile/ProfilePromote');

// Settings
const SettingsAccount = () => import(/* webpackChunkName: "settings" */ '../components/pages/settings/SettingsAccount');
const SettingsProfile = () => import(/* webpackChunkName: "settings" */ '../components/pages/settings/SettingsProfile');

const ifNotAuthenticated = (to, from, next) => {
    if (!store.getters.authenticated) {
        next();
        return;
    }
    next('/');
};

const ifAuthenticated = (to, from, next) => {
    if (store.getters.authenticated) {
        next();
        return;
    }
    next('/login');
};

// const ifPet = (to, from, next) => {
//     if (store.getters.authenticated && store.getters.selfProfile.type === 3) {
//         next();
//         return;
//     }
//     next('/');
// };

// const ifNotPet = (to, from, next) => {
//     if (store.getters.authenticated && store.getters.selfProfile.type !== 3) {
//         next();
//         return;
//     }
//     next('/');
// };

// const ROUTES_PHOTOS
// const ROUTES_VIDEOS
// const ROUTES_SETTINGS_ANNOUNCEMENTS

export default [
    {
        path: '/login',
        component: Login,
        meta: {title: 'Вход', bodyClass: 'login'},
        beforeEnter: ifNotAuthenticated
    },
    {
        path: '/register',
        component: Register,
        meta: {title: 'Регистрация', bodyClass: 'register'},
        beforeEnter: ifNotAuthenticated
    },
    {
        path: '/settings',
        component: SettingsLayout,
        beforeEnter: ifAuthenticated,
        children: [
            {
                path: '',
                redirect: '/settings/account'
            },
            {
                path: 'account',
                component: SettingsAccount,
                meta: {title: 'Настройки аккаунта', bodyClass: 'settings-account'},
            },
            {
                path: 'profile',
                component: SettingsProfile,
                meta: {title: 'Основные настройки профиля', bodyClass: 'settings-profile'},
            },
            {
                path: 'filemanager',
                component: FilemanagerLayout,
                meta: {title: 'Менеджер файлов', bodyClass: 'settings-filemanager'},
            },

            /*

            {
                path: 'breeder',
                component: PageSettingsBreeder,
                beforeEnter: ifNotPet,
                meta: {
                    title: 'Меню заводчика'
                }
            },
            {
                path: 'account',
                component: PageSettingsAccount,
                redirect: '/settings/account/login',
                children: [
                    {
                        path: 'login',
                        component: PageSettingsAccountLogin,
                        meta: {
                            title: 'Настройка аккаунта (логин)'
                        }
                    },
                    {
                        path: 'email',
                        component: PageSettingsAccountEmail,
                        meta: {
                            title: 'Настройка аккаунта (Email)'
                        }
                    },
                    {
                        path: 'password',
                        component: PageSettingsAccountPassword,
                        meta: {
                            title: 'Настройка аккаунта (пароль)'
                        }
                    }
                ]
            },
            {
                path: 'profile',
                component: PageSettingsProfile,
                redirect: '/settings/profile/main',
                children: [
                    {
                        path: 'main',
                        component: PageSettingsProfileMain,
                        meta: {
                            title: 'Основные настройки профиля'
                        }
                    },
                    {
                        path: 'work',
                        component: PageSettingsProfileWork,
                        meta: {
                            title: 'Работа'
                        }
                    },
                    {
                        path: 'contacts',
                        component: PageSettingsProfileContacts,
                        meta: {
                            title: 'Контактные данные'
                        }
                    },
                    {
                        path: 'education',
                        component: PageSettingsProfileEducation,
                        meta: {
                            title: 'Образование'
                        }
                    },
                    {
                        path: 'passport',
                        component: PageSettingsProfilePassport,
                        meta: {
                            title: 'Паспорт'
                        }
                    },
                    {
                        path: 'pedigree',
                        component: PageSettingsProfilePedigree,
                        meta: {
                            title: 'Родословная'
                        }
                    }
                ]
            },
            {
                path: 'privacy',
                component: PageSettingsPrivacy,
                meta: {
                    title: 'Конфиденциальность'
                }
            },
            {
                path: 'security',
                component: PageSettingsPrivacy,
                meta: {
                    title: 'Безопасность'
                }
            },
            {
                path: 'lock',
                component: PageSettingsPrivacy,
                meta: {
                    title: 'Блокировка'
                }
            },
            {
                path: 'announcements',
                component: PageSettingsAnnouncements,
                beforeEnter: ifNotPet,
                children: [
                    {
                        path: '',
                        component: PageSettingsAnnouncementsIndex,
                        meta: {
                            title: 'Мои объявления'
                        }
                    },
                    {
                        path: 'favorites',
                        component: PageSettingsAnnouncementsFavorites,
                        meta: {
                            title: 'Избранные'
                        }
                    }
                ]
            },
            {
                path: 'announcements/create',
                component: PageSettingsAnnouncementsCreate,
                beforeEnter: ifNotPet,
                meta: {
                    title: 'Создание объявления'
                }
            },
            {
                path: 'announcements/:id/edit',
                component: PageSettingsAnnouncementsEdit,
                beforeEnter: ifNotPet,
                meta: {
                    title: 'Редактирование объявления'
                }
            },
            {
                path: 'shops',
                component: PageSettingsShops,
                beforeEnter: ifNotPet,
                children: [
                    {
                        path: '',
                        component: PageSettingsShopsIndex,
                        meta: {
                            title: 'Мои магазины'
                        }
                    },
                    {
                        path: 'favorites',
                        component: PageSettingsShopsFavorites,
                        meta: {
                            title: 'Избранные магазины'
                        }
                    }
                ]
            },
            {
                path: 'shops/create',
                component: PageSettingsShopsCreate,
                beforeEnter: ifNotPet,
                meta: {
                    title: 'Создание магазина'
                }
            },
            {
                path: 'shops/:id/edit',
                component: PageSettingsShopsEdit,
                beforeEnter: ifNotPet,
                meta: {
                    title: 'Редактирование магазина'
                }
            },
            {
                path: 'wallet',
                component: PageSettingsWallet,
                children: [
                    {
                        path: '',
                        component: PageSettingsWalletMain,
                        meta: {
                            title: 'Пополнить счет'
                        }
                    },
                    {
                        path: 'history',
                        component: PageSettingsWalletHistory,
                        meta: {
                            title: 'История операций'
                        }
                    }
                ]
            },
            {
                path: 'destroy',
                component: PageSettingsDestroy,
                meta: {
                    title: 'Удалить аккаунт'
                }
            },
            {
                path: 'communities',
                //component: PageSettingsCommunities,
                redirect: '/settings/communities/create',
                children: [
                    {
                        path: 'create',
                        component: PageSettingsCommunitiesCreate,
                        meta: {
                            title: 'Создание сообщества'
                        }
                    }
                ]
            },
            {
                path: 'communities/create',
                component: PageSettingsCommunitiesCreate,
                meta: {
                    title: 'Создание сообщества'
                }
            },
            {
                path: 'communities/:id/edit',
                component: PageSettingsCommunitiesEdit,
                meta: {
                    title: 'Редактирование сообщества'
                },
                children: [
                    {
                        path: '',
                        component: PageSettingsCommunitiesEditMain
                    },
                    {
                        path: 'communities',
                        component: PageSettingsCommunitiesEditCommunities
                    },
                    {
                        path: 'profiles',
                        component: PageSettingsCommunitiesEditProfiles
                    }
                ]
            }

             */
        ]
    },
    {
        path: '/:slug',
        component: ProfileLayout,
        children: [
            {
                path: '',
                component: Profile,
                meta: {title: 'Профиль', bodyClass: 'profile'},
            },
            {
                path: 'photos',
                component: ProfilePhotos,
                meta: {title: 'Фото', bodyClass: 'profile-photos'},
            },
            {
                path: 'videos',
                component: ProfileVideos,
                meta: {title: 'Видео', bodyClass: 'profile-videos'},
            },
            {
                path: 'news',
                component: ProfileNews,
                meta: {title: 'Новости', bodyClass: 'profile-news'},
            },
            {
                path: 'friends',
                component: ProfileFriends,
                meta: {title: 'Друзья', bodyClass: 'profile-friends'},
            },
            {
                path: 'pages',
                component: ProfilePages,
                meta: {title: 'Страницы', bodyClass: 'profile-pages'},
            },
            {
                path: 'groups',
                component: ProfileGroups,
                meta: {title: 'Группы', bodyClass: 'profile-groups'},
            },
            {
                path: 'nurseries',
                component: ProfileNurseries,
                meta: {title: 'Питомники', bodyClass: 'profile-nurseries'},
            },
            {
                path: 'announcements',
                component: ProfileAnnouncements,
                meta: {title: 'Объявления', bodyClass: 'profile-announcements'},
            },
            {
                path: 'promote',
                component: ProfilePromote,
                meta: {title: 'Продвижение', bodyClass: 'profile-promote'},
            },
        ]
    }
];
