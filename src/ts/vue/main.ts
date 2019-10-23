import Vue from 'vue';
new Vue({
  el:	'#app1',
  data: {
    isShow: ''
  }
});

new Vue({
  el:	'#app2',
  data: {
    isShow: true
  }
});

new Vue({
  el:	'#app3',
  data: {
    isShow: true
  },
  computed: {
    showString: function () {
      return (this.isShow ? Date.now() : 'isShow は Falseです' );
    },
    showString2: function () {
      return Date.now();
    }
  },
  methods: {
    showStringMethods: function () {
      return (this.isShow ? Date.now() : 'isShow は Falseです' );
    },
    showStringMethods2: function () {
      return Date.now();
    }
  }
});


new Vue({
  el:	'#app4',
  data: {
    script: '<p>aa</p>'
  }
});

new Vue({
  el:	'#app6',
  data: {
    show: "true"
  }
});


Vue.component('button-counter', {
  data: function () {
    return {count:0}
  },
  
  template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>'
})
new Vue({el: "#app7"});

Vue.component('blog-post', {
  props: ['title'],
  template: '<h3>{{ title }}</h3>'
});

new Vue({
  el: '#app8'
});

Vue.component('blog-post', {
  props: ['post'],
  template: 
  `<div class="blog-post">
    <h3>{{ post.title }}</h3>
    <button v-on:click="$emit('enlarge-text')">Enlarge Text</button>
    <div v-html="post.content">
    </div>
  </div>`
});

new Vue({
  el: '#app9',
  data: {
    posts: [
      {
        id: 1,
        title: 'sample post1',
        content: '<p>サンプル投稿のコンテント</p>'
      },
      {
        id: 2,
        title: 'sample post2',
        content: '<p>サンプル投稿のコンテント</p>'
      },
      {
        id: 3,
        title: 'sample post3',
        content: '<p>サンプル投稿のコンテント</p>'
      }
    ],
    postFontSize: 1
  },
  methods: {
    fontSizeScale() {
      this.postFontSize += 0.1;
    }
  }
});