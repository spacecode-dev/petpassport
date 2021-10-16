import store from '../store';

const PageLogin = () => import(/* webpackChunkName: "js/auth" */ '../components/pages/PageLogin');
const PageRegister = () => import(/* webpackChunkName: "js/auth" */ '../components/pages/PageRegister');

import PageAbout from '../components/pages/PageAbout';

const LayoutSettings = () => import(/* webpackChunkName: "js/settings" */ '../components/layouts/LayoutSettings');

const PageSettingsBreeder = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/PageSettingsBreeder');

const PageSettingsAccount = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/account/PageSettingsAccount');
const PageSettingsAccountLogin = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/account/PageSettingsAccountLogin');
const PageSettingsAccountEmail = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/account/PageSettingsAccountEmail');
const PageSettingsAccountPassword = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/account/PageSettingsAccountPassword');

const PageSettingsProfile = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/profile/PageSettingsProfile');
const PageSettingsProfileMain = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/profile/PageSettingsProfileMain');
const PageSettingsProfileContacts = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/profile/PageSettingsProfileContacts');
const PageSettingsProfilePedigree = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/profile/PageSettingsProfilePedigree');
const PageSettingsProfileWork = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/profile/PageSettingsProfileWork');
const PageSettingsProfileEducation = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/profile/PageSettingsProfileEducation');
const PageSettingsProfilePassport = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/profile/PageSettingsProfilePassport');

const PageSettingsPrivacy = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/PageSettingsPrivacy');

const PageSettingsAnnouncements = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/announcements/PageSettingsAnnouncements');
const PageSettingsAnnouncementsIndex = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/announcements/PageSettingsAnnouncementsIndex');
const PageSettingsAnnouncementsFavorites = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/announcements/PageSettingsAnnouncementsFavorites');
const PageSettingsAnnouncementsCreate = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/announcements/PageSettingsAnnouncementsCreate');
const PageSettingsAnnouncementsEdit = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/announcements/PageSettingsAnnouncementsEdit');

const PageSettingsShops = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/shops/PageSettingsShops');
const PageSettingsShopsIndex = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/shops/PageSettingsShopsIndex');
const PageSettingsShopsFavorites = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/shops/PageSettingsShopsFavorites');
const PageSettingsShopsCreate = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/shops/PageSettingsShopsCreate');
const PageSettingsShopsEdit = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/shops/PageSettingsShopsEdit');

const PageSettingsWallet = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/wallet/PageSettingsWallet');
const PageSettingsWalletMain = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/wallet/PageSettingsWalletMain');
const PageSettingsWalletHistory = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/wallet/PageSettingsWalletHistory');

const PageSettingsDestroy = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/PageSettingsDestroy');

const PageSettingsCommunitiesCreate = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/communities/PageSettingsCommunitiesCreate');
const PageSettingsCommunitiesEdit = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/communities/edit/PageSettingsCommunitiesEdit');
const PageSettingsCommunitiesEditMain = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/communities/edit/PageSettingsCommunitiesEditMain');
const PageSettingsCommunitiesEditCommunities = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/communities/edit/PageSettingsCommunitiesEditCommunities');
const PageSettingsCommunitiesEditProfiles = () => import(/* webpackChunkName: "js/settings" */ '../components/pages/settings/communities/edit/PageSettingsCommunitiesEditProfiles');

const PageMarket = () => import(/* webpackChunkName: "js/market" */ '../components/pages/market/PageMarket');
const PageMarketCategories = () => import(/* webpackChunkName: "js/market" */ '../components/pages/market/PageMarketCategories');
const PageShop = () => import(/* webpackChunkName: "js/market" */ '../components/pages/market/PageShop');

const PageMarketAnnouncement = () => import(/* webpackChunkName: "js/market" */ '../components/pages/market/announcements/PageMarketAnnouncement');
const PageMarketAnnouncementsSearch = () => import(/* webpackChunkName: "js/market" */ '../components/pages/market/announcements/PageMarketAnnouncementsSearch');

const PageProfile = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/PageProfile');
const PageProfileMain = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/PageProfileMain');
const PageProfileNews = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/PageProfileNews');
const PageProfileShops = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/PageProfileShops');

const PagePhotos = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/photos/PagePhotos');
const PagePhotosList = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/photos/PagePhotosList');
const PagePhotosAlbums = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/photos/PagePhotosAlbums');
const PagePhotosAlbumsCreate = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/photos/PagePhotosAlbumsCreate');
const PagePhotosAlbumsEdit = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/photos/PagePhotosAlbumsEdit');

const PageVideos = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/videos/PageVideos');
const PageVideosList = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/videos/PageVideosList');
const PageVideosAlbums = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/videos/PageVideosAlbums');
const PageVideosAlbumsCreate = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/videos/PageVideosAlbumsCreate');
const PageVideosAlbumsEdit = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/videos/PageVideosAlbumsEdit');

const PageProfileCommunities = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/communities/PageProfileCommunities');
const PageProfileCommunitiesMain = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/communities/PageProfileCommunitiesMain');

const PageProfileFriends = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/friends/PageProfileFriends');
const PageProfileFriendsMain = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/friends/PageProfileFriendsMain');
const PageProfileFriendsSubscribers = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/friends/PageProfileFriendsSubscribers');
const PageProfileFriendsSubscriptions = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/friends/PageProfileFriendsSubscriptions');
const PageProfileFriendsRequests = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/friends/PageProfileFriendsRequests');

const PageProfileReviews = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/PageProfileReviews');
const PageProfileAnnouncements = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/announcements/PageProfileAnnouncements');
const PageProfileAnnouncementsMain = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/announcements/PageProfileAnnouncementsMain');
const PageProfileAnnouncementsFavorites = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/announcements/PageProfileAnnouncementsFavorites');

const PageProfileSearch = () => import(/* webpackChunkName: "js/profile" */ '../components/pages/profile/PageProfileSearch');

const PageCommunity = () => import(/* webpackChunkName: "js/community" */ '../components/pages/community/PageCommunity');
const PageCommunityMain = () => import(/* webpackChunkName: "js/community" */ '../components/pages/community/PageCommunityMain');
const PageCommunityMembers = () => import(/* webpackChunkName: "js/community" */ '../components/pages/community/PageCommunityMembers');
const PageCommunitySubscribers = () => import(/* webpackChunkName: "js/community" */ '../components/pages/community/PageCommunitySubscribers');
const PageCommunityLikes = () => import(/* webpackChunkName: "js/community" */ '../components/pages/community/PageCommunityLikes');
const PageCommunityPets = () => import(/* webpackChunkName: "js/community" */ '../components/pages/community/PageCommunityPets');
const PageCommunityGraduates = () => import(/* webpackChunkName: "js/community" */ '../components/pages/community/PageCommunityGraduates');
const PageCommunityEvents = () => import(/* webpackChunkName: "js/community" */ '../components/pages/community/PageCommunityEvents');
const PageCommunityEventsCreate = () => import(/* webpackChunkName: "js/community" */ '../components/pages/community/PageCommunityEventsCreate');

import PageSOS from '../components/pages/PageSOS';

const PagePedigree = () => import(/* webpackChunkName: "js/pedigree" */ '../components/pages/profile/PagePedigree');
const PagePassport = () => import(/* webpackChunkName: "js/passport" */ '../components/pages/profile/PagePassport');
const PageCard = () => import(/* webpackChunkName: "js/petcard" */ '../components/pages/profile/PageCard');

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
}

const ifPet = (to, from, next) => {
    if (store.getters.authenticated && store.getters.selfProfile.type == 3) {
        next();
        return;
    }
    next('/');
}

const ifNotPet = (to, from, next) => {
    if (store.getters.authenticated && store.getters.selfProfile.type != 3) {
        next();
        return;
    }
    next('/');
}


const ROUTES_PHOTOS = {
    path: 'photos',
    component: PagePhotos,
    children: [
        {
            path: 'albums',
            component: PagePhotosAlbums
        },
        {
            path: 'albums/create',
            component: PagePhotosAlbumsCreate
        },
        {
            path: 'albums/:album_id/edit',
            component: PagePhotosAlbumsEdit
        },
        {
            path: 'albums/:album_id/:photo_id?',
            component: PagePhotosList
        },
        {
            path: ':photo_id?',
            component: PagePhotosList
        }
    ]
};

const ROUTES_VIDEOS = {
    path: 'videos',
    component: PageVideos,
    children: [
        {
            path: 'albums',
            component: PageVideosAlbums
        },
        {
            path: 'albums/create',
            component: PageVideosAlbumsCreate
        },
        {
            path: 'albums/:album_id/edit',
            component: PageVideosAlbumsEdit
        },
        {
            path: 'albums/:album_id/:photo_id?',
            component: PageVideosList
        },
        {
            path: ':photo_id?',
            component: PageVideosList
        }
    ]
};

const ROUTES_SETTINGS_ANNOUNCEMENTS = {

};

export default [
    {path: '/login', component: PageLogin, meta: {title: 'Вход'}, beforeEnter: ifNotAuthenticated},
    {path: '/register', component: PageRegister, meta: {title: 'Регистрация'}, beforeEnter: ifNotAuthenticated},
    {path: '/about', component: PageAbout, meta: {title: 'О нас'}},
    {path: '/settings', component: LayoutSettings, beforeEnter: ifAuthenticated,
        children: [
            {path: '/', redirect: '/settings/account'},
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
            /*
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
            }
            */,
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
        ]
    },
    {
        path: '/market',
        component: PageMarket
    },
    {
        path: '/market/categories',
        component: PageMarketCategories
    },
    {
        path: '/market/shops/:id',
        component: PageShop,
        meta: {
            title: 'Магазин'
        }
    },
    {
        path: '/market/announcements',
        component: PageMarketAnnouncementsSearch,
        meta: {
            title: 'Поиск объявлений',
            preserveScroll: true
        }
    },
    {
        path: '/market/announcements/:id',
        component: PageMarketAnnouncement,
        meta: {
            title: 'Объявление'
        }
    },
    {
        path: '/sos',
        component: PageSOS
    },
    {
        path: '/profiles/search',
        component: PageProfileSearch
    },
    {
        path: '/:type(pages|groups|nurseries|breeds)/:slug',
        component: PageCommunity,
        children: [
            {
                path: '',
                component: PageCommunityMain
            },
            ...[ ROUTES_PHOTOS ],
            ...[ ROUTES_VIDEOS ],
            {
                path: 'members',
                component: PageCommunityMembers
            },
            {
                path: 'subscribers',
                component: PageCommunitySubscribers
            },
            {
                path: 'likes',
                component: PageCommunityLikes
            },
            {
                path: 'pets',
                component: PageCommunityPets
            },
            {
                path: 'graduates',
                component: PageCommunityGraduates
            },
            {
                path: 'events',
                component: PageCommunityEvents
            },
            {
                path: 'events/create',
                component: PageCommunityEventsCreate
            }
        ]
    },
    {
        path: '/:slug/pedigree',
        component: PagePedigree
    },
    {
        path: '/:slug/passport',
        component: PagePassport
    },
    {
        path: '/:slug/card',
        component: PageCard
    },
    {
        path: '/:slug',
        component: PageProfile,
        children: [
            {
                path: '',
                component: PageProfileMain,
                meta: {
                    title: 'Профиль'
                }
            },
            {
                path: 'news',
                component: PageProfileNews,
                meta: {
                    title: 'Новости'
                }
            },
            {
                path: 'friends',
                component: PageProfileFriends,
                children: [
                    {
                        path: '',
                        component: PageProfileFriendsMain,
                        meta: {
                            title: 'Друзья'
                        }
                    },
                    {
                        path: 'subscribers',
                        component: PageProfileFriendsSubscribers,
                        meta: {
                            title: 'Подписчики'
                        }
                    },
                    {
                        path: 'subscriptions',
                        component: PageProfileFriendsSubscriptions,
                        meta: {
                            title: 'Читаемые'
                        }
                    },
                    {
                        path: 'requests',
                        component: PageProfileFriendsRequests,
                        meta: {
                            title: 'Запросы о дружбе'
                        }
                    }
                ]
            },
            {
                path: ':type(pages|groups|nurseries)',
                component: PageProfileCommunities,
                children: [
                    {
                        path: '',
                        component: PageProfileCommunitiesMain
                    }
                ]
            },
            ...[ ROUTES_PHOTOS ],
            ...[ ROUTES_VIDEOS ],
            {
                path: 'reviews',
                component: PageProfileReviews
            },
            {
                path: 'announcements',
                component: PageProfileAnnouncements,
                children: [
                    {
                        path: '',
                        component: PageProfileAnnouncementsMain
                    },
                    {
                        path: 'favorites',
                        component: PageProfileAnnouncementsFavorites
                    }
                ]
            },
            {
                path: 'shops',
                component: PageProfileShops
            }
        ],
        meta: {
            preserveScroll: true
        }
    }
];
