import Vue from 'vue';
import axios from 'axios';
const usr = new URLSearchParams();
Vue.component("vue-form", {
 
});
let obj: Vue = new Vue({
  el: "#vue-form",

  data: {
    email: "",
    emailCheck: "",
    detail_message: "",
    error_message2: "",
    regexp_email: new RegExp("^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$"),
    error_message_email: "",
    json_data: ""
  },
  computed: {
    error_Message: function () {
      return this.email === this.emailCheck ? "" : "一致してません";
    },

    buttonFlag: function () {
      return this.error_Message === "" && this.detail_message !== "" ? false: true;
    }
  },

  methods: {
    key_up__textarea: function () {
      return this.detail_message === "" ? this.error_message2 = "入力してください" :　this.error_message2 = "" ;
    },
    /*
    vf_Submit: function () {
      //Email判定
      let regexp_result = this.v_required(this.email);
    
      //結果を非同期で、バックエンドに通信を行う
      if (regexp_result === true) {

        //csrfトークン生成
        //this.csrfToken = "test";
        this.aync_function();
      }
    },
    v_required: function (val:string){
      let result = val.match(this.regexp_email);
      if (result == null) {
        this.error_message_email = "メールアドレスの形式で入力してください";
        alert(this.error_message_email);
        return
      }
      this.error_message_email = "";
      return true;
    },
    
    aync_function: function() {

      usr.append('email', this.email);
      usr.append('detail', this.detail);
      //usr.append('csrfToken', this.csrfToken);
      axios.post('/dist/form/index.php', usr)
        .then(res => {
          console.log(res.data)
          this.json_data = res.data;
        })
        .catch(err => console.log(err))
        .finally(() => console.log('finally'));
    }*/
  }
});
/*
headers: { 'content-type': 'application/x-www-form-urlencoded' },

responseType: 'json'*/