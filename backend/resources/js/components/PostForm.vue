<template>
  <div v-show="value" class="photo-form">
    <h2 class="title">投稿する</h2>
    <div v-show="loading" class="panel">
      <Loader>送信中...</Loader>
    </div>
    <form v-show="! loading" class="form" @submit.prevent="submit">
      <div class="errors" v-if="errors">
        <ul v-if="errors.postForm">
          <li v-for="msg in errors.postForm" :key="msg">{{ msg }}</li>
        </ul>
      </div>
      <label for="work_type">作業名</label>
      <input class="form__item" type="text" id="work_type" v-model="postForm.work_type">
      <label for="room_name">ルーム名</label>
      <input class="form__item" type="text" id="room_name" v-model="postForm.room_name">
      <label for="start">開始時刻</label>
      <input class="form__item" type="datetime-local" id="start" v-model="postForm.start">
      <label for="end">終了時刻</label>
      <input class="form__item" type="datetime-local" id="end" v-model="postForm.end">
      <div class="form__button">
        <button type="submit" class="button button--inverse">投稿する</button>
      </div>
    </form>
  </div>
</template>


<script>
import {CREATED, UNPROCESSABLE_ENTITY} from "../util";
import Loader from './Loader.vue'

export default {
  components: {
    Loader
  },
  data () {
    return {
      loading: false,
      postForm: {
        work_type: '',
        room_name: '',
        start: '',
        end: ''
      },
      errors: null
    }
  },
  props: {
    value: {
      type: Boolean,
      required: true
    }
  },
  methods: {
    async submit () {
      this.loading = true
      const response = await axios.post('/api/posts', this.postForm)
      this.loading = false

      if (response.status === UNPROCESSABLE_ENTITY) {
        this.errors = response.data.errors
        return false
      }

      this.$emit('input', false)

      if (response.status !== CREATED) {
        this.$store.commit('errors/setCode', response.status)
        return false
      }

      // メッセージ登録
      this.$store.commit('message/setContent', {
        content: '投稿が完了しました！',
        timeout: 6000
      })

      this.$router.push(`/posts/${response.data.id}`)
    }
  }
}
</script>
