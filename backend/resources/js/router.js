import Vue from 'vue'
import VueRouter from 'vue-router'


// ページコンポーネントをインポート
import Login from './pages/Login.vue'
import PostIndex from './pages/PostIndex.vue'


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
    component: Login
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