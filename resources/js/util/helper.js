const getToast = (self, variant, message) => {
    return self.$buefy.toast.open({
        duration: 5000,
        message: message,
        position: 'is-top',
        type: 'is-' + variant
    })
};

export {
    getToast
};
