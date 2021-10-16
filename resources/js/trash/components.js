import Vue from 'vue';
import lineClamp from 'vue-line-clamp'
Vue.use(lineClamp);

import LayoutMain from './components/layouts/LayoutMain';
Vue.component('LayoutMain', LayoutMain);
import IncludeStars from './components/includes/IncludeStars';
Vue.component('IncludeStars', IncludeStars);
import IncludeReview from './components/includes/IncludeReview';
Vue.component('IncludeReview', IncludeReview);
import IncludePagination from './components/includes/IncludePagination';
Vue.component('IncludePagination', IncludePagination);
import IncludeInputWithFilter from './components/includes/controls/IncludeInputWithFilter';
Vue.component('IncludeInputWithFilter', IncludeInputWithFilter);
import IncludeInputSearchProfile from './components/includes/controls/IncludeInputSearchProfile';
Vue.component('IncludeInputSearchProfile', IncludeInputSearchProfile);
import IncludeInputSearchCommunity from './components/includes/controls/IncludeInputSearchCommunity';
Vue.component('IncludeInputSearchCommunity', IncludeInputSearchCommunity);
import IncludeDropdown from './components/includes/controls/IncludeDropdown';
Vue.component('IncludeDropdown', IncludeDropdown);
import IncludeSearch from './components/includes/controls/IncludeSearch';
Vue.component('IncludeSearch', IncludeSearch);

//Search component
const IncludeGlobalSearchResult = () => import(/* webpackChunkName: "js/market" */ './components/includes/search/IncludeGlobalSearchResult.vue');
Vue.component('IncludeGlobalSearchResult', IncludeGlobalSearchResult);

import IncludeHeaderFilters from './components/includes/IncludeHeaderFilters';
Vue.component('IncludeHeaderFilters', IncludeHeaderFilters);

import IncludeComments from './components/includes/IncludeComments';
Vue.component('IncludeComments', IncludeComments);
import IncludeComment from './components/includes/IncludeComment';
Vue.component('IncludeComment', IncludeComment);
import IncludeVideoPlayer from './components/includes/IncludeVideoPlayer';
Vue.component('IncludeVideoPlayer', IncludeVideoPlayer);

/* modals */
const ModalReviewAdd = () => import(/* webpackChunkName: "js/modals" */ './components/includes/modals/ModalReviewAdd');
Vue.component('ModalReviewAdd', ModalReviewAdd);
const ModalUserContact = () => import(/* webpackChunkName: "js/modals" */ './components/includes/modals/ModalUserContact');
Vue.component('ModalUserContact', ModalUserContact);
const ModalVideosUpload = () => import(/* webpackChunkName: "js/modals" */ './components/includes/modals/ModalVideosUpload');
Vue.component('ModalVideosUpload', ModalVideosUpload);
const ModalMediaView = () => import(/* webpackChunkName: "js/modals" */ './components/includes/modals/ModalMediaView');
Vue.component('ModalMediaView', ModalMediaView);
const ModalCart = () => import(/* webpackChunkName: "js/modals" */ './components/includes/modals/ModalCart');
Vue.component('ModalCart', ModalCart);

/* settings */
const ModalChangeCurrency = () => import(/* webpackChunkName: "js/settings" */ './components/includes/modals/ModalChangeCurrency');
Vue.component('ModalChangeCurrency', ModalChangeCurrency);
const ModalUserDestroy = () => import(/* webpackChunkName: "js/settings" */ './components/includes/modals/ModalUserDestroy');
Vue.component('ModalUserDestroy', ModalUserDestroy);

/* profile */
const IncludeHeaderProfile = () => import(/* webpackChunkName: "js/profile" */ './components/includes/IncludeHeaderProfile');
Vue.component('IncludeHeaderProfile', IncludeHeaderProfile);
const ModalSelectPhotos = () => import(/* webpackChunkName: "js/profile" */ './components/includes/modals/ModalSelectPhotos');
Vue.component('ModalSelectPhotos', ModalSelectPhotos);
const ModalCropAvatar = () => import(/* webpackChunkName: "js/profile" */ './components/includes/modals/ModalCropAvatar');
Vue.component('ModalCropAvatar', ModalCropAvatar);
const ModalCropBackground = () => import(/* webpackChunkName: "js/profile" */ './components/includes/modals/ModalCropBackground');
Vue.component('ModalCropBackground', ModalCropBackground);
const ModalPhoto = () => import(/* webpackChunkName: "js/profile" */ './components/includes/modals/ModalPhoto');
Vue.component('ModalPhoto', ModalPhoto);
const ModalCommunityRoles = () => import(/* webpackChunkName: "js/profile" */ './components/includes/modals/ModalCommunityRoles');
Vue.component('ModalCommunityRoles', ModalCommunityRoles);

const IncludeHeaderCommunity = () => import(/* webpackChunkName: "js/profile" */ './components/includes/IncludeHeaderCommunity');
Vue.component('IncludeHeaderCommunity', IncludeHeaderCommunity);

const IncludePosts = () => import(/* webpackChunkName: "js/profile" */ './components/includes/IncludePosts');
Vue.component('IncludePosts', IncludePosts);
const IncludePost = () => import(/* webpackChunkName: "js/profile" */ './components/includes/IncludePost');
Vue.component('IncludePost', IncludePost);
const IncludePostForm = () => import(/* webpackChunkName: "js/profile" */ './components/includes/IncludePostForm');
Vue.component('IncludePostForm', IncludePostForm);

const IncludeSubscribers = () => import(/* webpackChunkName: "js/profile" */ './components/includes/IncludeSubscribers');
Vue.component('IncludeSubscribers', IncludeSubscribers);

//const IncludePedigreeBlock = () => import(/* webpackChunkName: "js/pedigree" */ './components/includes/IncludePedigreeBlock');
//Vue.component('IncludePedigreeBlock', IncludePedigreeBlock);
const IncludePedigreeCard = () => import(/* webpackChunkName: "js/pedigree" */ './components/includes/IncludePedigreeCard');
Vue.component('IncludePedigreeCard', IncludePedigreeCard);
const ModalPedigreeCard = () => import(/* webpackChunkName: "js/pedigree" */ './components/includes/modals/ModalPedigreeCard');
Vue.component('ModalPedigreeCard', ModalPedigreeCard);

/* market */
const IncludeHeaderShop = () => import(/* webpackChunkName: "js/market" */ './components/includes/IncludeHeaderShop');
Vue.component('IncludeHeaderShop', IncludeHeaderShop);
const IncludeAnnouncement = () => import(/* webpackChunkName: "js/market" */ './components/includes/IncludeAnnouncement');
Vue.component('IncludeAnnouncement', IncludeAnnouncement);
const IncludeAnnouncementAside = () => import(/* webpackChunkName: "js/market" */ './components/includes/IncludeAnnouncementAside');
Vue.component('IncludeAnnouncementAside', IncludeAnnouncementAside);
const IncludeMarketCategory = () => import(/* webpackChunkName: "js/market" */ './components/includes/IncludeMarketCategory');
Vue.component('IncludeMarketCategory', IncludeMarketCategory);
const IncludeAnnouncementPromoteModal = () => import(/* webpackChunkName: "js/market" */ './components/includes/IncludeAnnouncementPromoteModal');
Vue.component('IncludeAnnouncementPromoteModal', IncludeAnnouncementPromoteModal);
const ModalAnnouncementColor = () => import(/* webpackChunkName: "js/market" */ './components/includes/modals/ModalAnnouncementColor');
Vue.component('ModalAnnouncementColor', ModalAnnouncementColor);
const ModalAnnouncementPin = () => import(/* webpackChunkName: "js/market" */ './components/includes/modals/ModalAnnouncementPin');
Vue.component('ModalAnnouncementPin', ModalAnnouncementPin);
const ModalAnnouncementPushup = () => import(/* webpackChunkName: "js/market" */ './components/includes/modals/ModalAnnouncementPushup');
Vue.component('ModalAnnouncementPushup', ModalAnnouncementPushup);
const PageShopAnnouncements = () => import(/* webpackChunkName: "js/market" */ './components/pages/market/PageShopAnnouncements');
Vue.component('PageShopAnnouncements', PageShopAnnouncements);
const PageShopMoving = () => import(/* webpackChunkName: "js/market" */ './components/pages/market/PageShopMoving');
Vue.component('PageShopMoving', PageShopMoving);
const PageShopClinic = () => import(/* webpackChunkName: "js/market" */ './components/pages/market/PageShopClinic');
Vue.component('PageShopClinic', PageShopClinic);
const PageShopHotel = () => import(/* webpackChunkName: "js/market" */ './components/pages/market/PageShopHotel');
Vue.component('PageShopHotel', PageShopHotel);
const PageShopPhotograph = () => import(/* webpackChunkName: "js/market" */ './components/pages/market/PageShopPhotograph');
Vue.component('PageShopPhotograph', PageShopPhotograph);
const PageShopTraining = () => import(/* webpackChunkName: "js/market" */ './components/pages/market/PageShopTraining');
Vue.component('PageShopTraining', PageShopTraining);


