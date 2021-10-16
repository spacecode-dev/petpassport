import axios from 'axios';

export default {
    state: {

    },
    actions: {
        async PHOTOS_SELECT({ commit }, multiple) {
            return new Promise((resolve, reject) => {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.multiple = multiple ? true : false;
                input.style.position = 'fixed';
                input.style.left = '-9999px';
                input.style.top = '-9999px';
                input.onchange = (e) => {
                    resolve(e.target.files);
                };
                document.body.appendChild(input);
                input.click();
            });
        },
        async PHOTOS_UPLOAD({ commit }, params) {
            return new Promise((resolve, reject) => {
                const request = new FormData();

                for (let p in params) {
                    request.append(p, params[p]);
                }

                axios.post('/api/photos', request, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    if (response.data.post) {
                        commit('POSTS_UNSHIFT', response.data.post);
                    }
                    resolve(response.data);
                })
                .catch(err => {
                    reject(err);
                });
            });
        }
    }
}
