<script setup>
const currentYear = new Date().getFullYear();
const copyrightText = `© spa ${currentYear}, All rights reserved.`;
</script>

<template>
  <div class="site-footer">
    <div class="footer-dots"></div>
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <p>
            {{ copyrightText }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
