<script>
import Network from "../network-class";
import { Mentionable } from 'vue-mention'

export default {
  components: {
    Mentionable,
  },

  data () {
    return {
      text: '',
      items: [],
    }
  },

  methods: {
    onOpen : async function (key){
      this.items = await this.getPhrases();
    },
    onMentionSelect (mention) {
      this.text=this.text.replace(/#/g, '')
      this.$emit('text',this.text);
    },
    getPhrases: async function () {
        const data = await Network.get('/api/smartPhrases');
        return data.smartPhrases.map(phrase => ({value: phrase.phrase,label: phrase.key, searchText: phrase.key+' '+phrase.phrase }));
    },
  },
}
</script>

<template>
  <Mentionable
    :keys="['#']"
    :items="items"
    offset="5"
    limit="10"
    insert-space
    @open="onOpen"
    @apply="onMentionSelect"
  >
    <textarea
      v-model="text"
      ref="textarea"
      class="form-control"
      rows=5
    />

    <template #no-result>
      <div class="dim">
        No result
      </div>
    </template>


    <template #item-#="{ item }">
      <div class="issue">
        <span class="dim">
          #{{ item.label }}
        </span>
        <span class="number">
          {{ item.value }}
        </span>
      </div>
    </template>
    <p style="font-size:12px; line-height: 14px; margin-top:10px">This text field is connected to Afya Dynamics smart phrases. To trigger a smartphrase type the # key. A list of all smart phrases can be found <router-link to="/smartPhrase">here</router-link></p>
  </Mentionable>
</template>