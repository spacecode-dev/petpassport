import axios from 'axios';

export default {
    actions: {
        async getCountries() {
            return (await axios.get('/api/countries?lang=ru')).data;

            /*
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/countries?lang=ru')
                    .then(r => resolve(r.data));
            });
            */
        },
        async getCities({}, country_id) {
            if (country_id) {
                return (await axios.get('/api/cities?country_id=' + country_id + '&lang=ru')).data;
            }

            return null;

            /*
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/cities?country_id=' + country_id + '&lang=ru')
                    .then(r => resolve(r.data));
            });
            */
        }
    }
}
