import Vue from 'vue';

Vue.component ("button-counter", {
  data: function () {
    return {
      count: 0
    }
  },
  props: ["title"],

  template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>'
});


new Vue({ el: '#components-demo' })