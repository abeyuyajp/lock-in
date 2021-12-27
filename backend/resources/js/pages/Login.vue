<template>
  <div class="container--small">
    <ul class="tab">
      <li
        class="tab__item"
        :class="{ 'tab__item--active' : tab === 1 }"
        @click="tab = 1"
      >ログイン</li>
      <li
        class="tab__item"
        :class="{ 'tab__item--active' : tab === 2 }"
        @click="tab = 2"
      >新規登録</li>
    </ul>
    <!-- ログインフォーム -->
    <div class="panel" v-show="tab === 1">
      <form class="form" @submit.prevent="login">
        <div v-if="loginErrors" class="errors">
          <ul v-if="loginErrors.email">
            <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
          </ul>
          <ul v-if="loginErrors.password">
            <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
          </ul>
        </div>
        <label for="login-email">メールアドレス</label>
        <input type="text" class="form__item" id="login-email" v-model="loginForm.email">
        <label for="login-password">パスワード</label>
        <input type="password" class="form__item" id="login-password" v-model="loginForm.password">
        <div class="form__button">
          <button type="submit" class="button button--inverse">ログインする</button>
        </div>
      </form>
    </div>
    <!-- 新規登録フォーム -->
    <div class="panel" v-show="tab === 2">
      <form class="form" @submit.prevent="register">
        <div v-if="registerErrors" class="errors">
          <ul v-if="registerErrors.name">
            <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
          </ul>
          <ul v-if="registerErrors.email">
            <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
          </ul>
          <ul v-if="registerErrors.password">
            <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
          </ul>
        </div>
        <label for="username">ユーザー名</label>
        <input type="text" class="form__item" id="username" v-model="registerForm.name">
        <label for="Email">メールアドレス</label>
        <input type="text" class="form__item" id="email" v-model="registerForm.email">
        <label for="password">パスワード</label>
        <input type="password" class="form__item" id="password" v-model="registerForm.password">
        <label for="password-confirmation">パスワード（確認）</label>
        <input type="text" class="form__item" id="password-confirmation" v-model="registerForm.password_confirmation">
        <div class="form__button">
          <button type="submit" class="button button--inverse">新規登録する</button>
        </div>
      </form>
    </div>
  </div>
</template>


<script>
export default {
  data () {
    return {
      tab: 1,
      loginForm: {
        email: '',
        password: ''
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  computed: {
    apiStatus () {
      return this.$store.state.auth.apiStatus
    },
    loginErrors () {
      return this.$store.state.auth.loginErrorMessages
    },
    registerErrors () {
      return this.$store.state.auth.registerErrorMessages
    }
  },
  methods: {
    async login () {
      // authストアのloginアクションを呼び出す
      await this.$store.dispatch('auth/login', this.loginForm)

      if (this.apiStatus) {
        // トップページに移動する
        this.$router.push('/')
      }
    },
    async register () {
      // authストアのregisterアクションを呼び出す
      await this.$store.dispatch('auth/register', this.registerForm)

      if (this.apiStatus) {
        // トップページに移動する
        this.$router.push('/')
      }
    },
    async logout () {
      await this.$store.dispatch('auth/logout')
      this.$router.push('/login')
    },
    clearError () {
      this.$store.commit('auth/setLoginErrorMessages', null)
      this.$store.commit('auth/setRegisterErrorMessages', null)
    }
  },
  created () {
    this.clearError()
  }
}
</script>
