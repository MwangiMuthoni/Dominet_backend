<template>
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh; background-color: #f8f9fa;">
        <div class="text-center mt-5">
            <div class="mt-4">
                <img src="/img/checked.png" alt="Success" style="width: 80px; height: 80px;" />
            </div>
            <div class="mt-4">
                <h4 class="font-weight-bold" style="font-size: 30px; color: #28a745;">Success!</h4>
                <p style="font-size: 18px; color: #6c757d;">You have successfully signed out of the property.</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'signedOut',
    methods: {
    }
};
</script>

<style scoped>
h4 {
    font-size: 30px !important;
    color: #28a745;
}

p {
    font-size: 18px !important;
    color: #6c757d;
}

</style>
