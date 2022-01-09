import Vue from 'vue'
import VueRouter from 'vue-router'


// ページコンポーネントをインポート
import Login from './pages/Login.vue'
import PostIndex from './pages/PostIndex.vue'
import SystemError from './pages/errors/System.vue'
import PostDetail from './pages/PostDetail.vue'
import NotFound from './pages/errors/NotFound'

import store from './store'


// VueRouterプラグインを使用する
// これでRouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)


// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    component: PostIndex,
    props: route => {
      const page = route.query.page
      return { page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1 }
    }
  },
  {
    path: '/posts/:id',
    component: PostDetail,
    props: true
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
  },
  {
    path: '*',
    component: NotFound
  }
]


// VueRouterインスタンスを作成
const router = new VueRouter({
  mode: 'history',
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes
})


// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router
