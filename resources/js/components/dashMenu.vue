<template>
  <div @click="handleClick()">
    <div v-if="activeSection == section || section == null" :class="(activeTab == tab)?'dash-button-holder':'dash-button-inactive'">
      <div class="dash-button-left"><p></p></div>
        <div class="dash-button-center">
          <div :class="(activeTab == tab)?'dash-button-center-content':'dash-button-center-inactive'">
            {{label}}
          </div>
        </div>
      <div class="dash-button-right"><p></p></div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    handleClick() {
        this.$emit('click');
    }
  },
  props: {
    activeSection: [String, Number],
    activeTab: [String, Number],
    label: [String, Number],
    section: [String, Number],
    tab: [String, Number],
  }
};
</script>

<style>
/* Your styles here */
</style>
