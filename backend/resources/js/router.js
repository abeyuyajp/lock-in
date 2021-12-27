import Vue from 'vue'
import VueRouter from 'vue-router'


// ページコンポーネントをインポート
import Login from './pages/Login.vue'
import PostIndex from './pages/PostIndex.vue'
import SystemError from './pages/errors/System.vue'

import store from './store'


// VueRouterプラグインを使用する
// これでRouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)


// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    component: PostIndex
  },
  {
    path: '/login',
    component: Login,
    beforeEnter (to, from, next) {
      if (store.getters['auth/check']) {
        next('/')
      } else {
        next()
      }
    }
  },
  {
    path: '/500',
    component: SystemError
  }
]


// VueRouterインスタンスを作成
const router = new VueRouter({
  mode: 'history',
  routes
})


// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router
