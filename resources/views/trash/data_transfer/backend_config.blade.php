
<script>
    window.transferData = {};
    window.transferData.сurrenciesList = {!! json_encode(\App\Models\Currency::getWithTranslate()) !!};
    window.transferData.userTypes = {!! json_encode(\App\Models\UserType::getWithTranslate()) !!};
    window.transferData.petCategories = {!! json_encode(\App\Models\MarketCategory::getPetCategories()) !!};
    window.transferData.genderList = {!! json_encode(\App\Models\Gender::getWithTranslate()) !!};

</script>
