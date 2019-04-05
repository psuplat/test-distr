<template>
    <div class="login uk-flex uk-flex-center uk-margin-large-top uk-height-viewport">
        <div v-if="switcher === 'login'">
            <div class="uk-text-center">
                <form id="login-form" class="uk-form-stacked uk-animation-slide-top-small">
                        <span uk-icon="icon:lock; ratio:3"></span><br><br>
                        <legend class="uk-legend">Helloprint Access</legend>
                        <div class="uk-margin">
                          <div class="uk-inline">
                              <span class="uk-form-icon" uk-icon="icon: user"></span>
                              <input class="uk-input uk-form-width-large uk-form-large" id="input-login" type="text" placeholder="login" v-model="input.user" v-bind:class="{'uk-form-danger': hasLoginError }" autofocus v-on:keyup.enter="sendData()">
                          </div>
                        </div>
                        <div class="uk-margin">
                          <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: lock"></span>
                            <input class="uk-input uk-form-width-large uk-form-large" id="input-password" type="password" placeholder="password" v-model="input.pass" v-bind:class="{'uk-form-danger': hasPasswordError }" v-on:keyup.enter="sendData()">
                          </div>
                        </div>
                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary uk-button-large uk-form-width-large" id="btn-login" type="button" v-on:click="sendData()" v-html="login_button"></button><br>
                        <a href="#" @click="divSwitcher('recover',$event)">forgot your password?</a>
                    </div>
                </form>
                <div id="login-response" class="uk-text-center" v-html="login_response"></div>
                <div id="login-processing" class="uk-text-center" style="min-height:50px;margin-top:50px"></div>
            </div>
        </div>
        <div v-if="switcher === 'recover'">
            <div class="uk-text-center">
                <form id="login-form" class="uk-form-stacked uk-animation-slide-bottom-small">
                  <span uk-icon="icon:mail; ratio:3"></span><br><br>
                        <legend class="uk-legend">Helloprint Access<br><span class="uk-text-small">Password Recovery</span></legend>
                        <div class="uk-margin">
                          <div class="uk-inline">
                              <span class="uk-form-icon" uk-icon="icon: user"></span>
                              <input class="uk-input uk-form-width-large uk-form-large" id="input-login" type="text" placeholder="login" v-model="recover.user" v-bind:class="{'uk-form-danger': hasLoginRecoverError }" on:keyup.enter="sendData()">
                          </div>
                        </div>
                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary uk-button-large uk-form-width-large" id="btn-recover" type="button" v-on:click="sendRecoveryData()" v-html="recover_button"></button><br>
                        <a href="#" @click="divSwitcher('login',$event)">remembered your password?</a>
                    </div>
                </form>
                <div id="recover-response" class="uk-text-center" v-html="recovery_response"></div>
                <div id="recover-processing" class="uk-text-center" style="min-height:50px;margin-top:50px"></div>
            </div>
        </div>
        <div v-if="switcher === 'success'">
          <div class="uk-text-center uk-animation-scale-up">
            <span class="uk-text-success" uk-icon="icon:check; ratio:4"></span><br>
            <p class="uk-text-large">Welcome {{input.user}},<br>you have been successfully authenticated!</p><br><br>
            <a href="#" @click="divSwitcher('login',$event)">try again?</a>
          </div>
        </div>
    </div>
</template>

<script>
// @ is an alias to /src
//import HelloWorld from "@/components/HelloWorld.vue";
import axios from "axios";

export default {
  name: "login",
  components: {},
  data() {
    return {
      input: {
          user: "",
          pass: "",
      },
      recover: {
          user: "",
      },
      hasLoginError: false,
      hasPasswordError: false,
      hasLoginRecoverError: false,
      login_button: "LOGIN",
      recover_button: "Recover Password",
      login_response: "&nbsp;",
      recovery_response: "&nbsp;",
      switcher: "login",
    };
  },
  mounted() {
  },
  methods: {
    sendData() {
      if (this.input.user.length > 0) {
        this.hasLoginError = false;
      } else {
        this.hasLoginError = true;
      }
      if (this.input.pass.length > 0) {
        this.hasPasswordError = false;
      } else {
        this.hasPasswordError = true;
      }
      if(this.hasPasswordError == true || this.hasLoginError ==true)
      {
        this.login_response= '<span class="uk-text-danger"><span uk-icon="info"></span> please fill in the highlighted fields</span>';
      }
      if (this.hasPasswordError == false && this.hasLoginError == false) {
        this.login_button = "<div uk-spinner></div>";
        this.login_response = "";
        axios({
          method: "POST",
          url: process.env.VUE_APP_API+"login.php",
          data: this.input,
          headers: { "content-type": "application/json" },
          timeout: 5000,
        }).then(
          result => {
              this.login_button = "LOGIN";
              if (result.data.result == true && result.data.rows > 0) {
                this.hasLoginError = false;
                this.hasPasswordError = false;
                this.hasLoginRecoverError = false;
                this.login_response ="&nbsp;";
                this.recovery_response = "&nbsp;";
                this.switcher = 'success';
              }
              if (result.data.result == true && result.data.rows == 0) {
                this.login_response = '<span class="uk-text-danger"><span uk-icon="warning"></span> invalid credentials!</span>';
              }
              else {
                  this.login_response = '<span class="uk-text-danger"><span uk-icon="warning"></span> Error occured!<br>Response status: ' + result.status +'</span>';
              }
          },
          error => {
            this.login_button = "login";
            this.login_response = '<span class="uk-text-danger"><span uk-icon="warning"></span><br>' + error +'</span>';
            console.log(error);
          }
        );
      }
    },
    sendRecoveryData() {
      if (this.recover.user.length > 0) {
        this.hasLoginRecoverError = false;
        this.recovery_response= '';
      } else {
        this.hasLoginRecoverError = true;
        this.recovery_response= '<span class="uk-text-danger"><span uk-icon="info"></span> your login is required</span>';
      }

      if (this.hasLoginRecoverError == false) {
        this.recover_button = "<div uk-spinner></div>";
        this.recovery_response = "";
        axios({
          method: "POST",
          url: process.env.VUE_APP_API+"recover.php",
          data: this.recover,
          headers: { "content-type": "application/json" },
          timeout: 5000,
        }).then(
          result => {
              this.recover_button = "Recover Password";
              if (result.data.email_result == true) {
                this.hasLoginError = false;
                this.hasPasswordError = false;
                this.hasLoginRecoverError = false;
                this.login_response ="&nbsp;";
                this.recovery_response = "&nbsp;";
                this.switcher = 'login';
                this.login_response = '<span class="uk-text-success"><span uk-icon="check"></span> Your credentials have been sent to you.<br>Check your email and try again.</span>';
              }
              else if (result.data.result == true && result.data.rows == 0) {
                this.recovery_response = '<span class="uk-text-danger"><span uk-icon="warning"></span> unknown user!</span>';
              }
              else {
                  this.recovery_response = '<span class="uk-text-danger"><span uk-icon="warning"></span> Error occured!</span>';
              }
          },
          error => {
            this.recover_button = "Recover Password";
            this.recovery_response = '<span class="uk-text-danger"><span uk-icon="warning"></span><br>' + error +'</span>';
            console.log(error);
          }
        );
      }
    },
    divSwitcher(switch_val, event) {
      event.preventDefault();
      //reset alerts and switch
      this.hasLoginError = false;
      this.hasPasswordError = false;
      this.hasLoginRecoverError = false;
      this.login_response ="&nbsp;";
      this.recovery_response = "&nbsp;";
      this.input.user = "";
      this.input.pass = "";
      this.recover.user = "";
      this.switcher = switch_val;
    }
  }
};
</script>
