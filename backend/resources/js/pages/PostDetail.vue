<template>
  <div v-if="post" class="photo-detail">
    <figure class="photo-detail__pane photo-detail__image">
      <p>{{post.work_type}}</p>
      <p>{{post.room_name}}</p>
      <p>{{post.start}}</p>
      <p>{{post.end}}</p>
      <p>{{post.owner.name}}</p>
    </figure>
    <div class="photo-detail__pane">
      <button class="button button--like" title="Like Post">
        <i class="icon icon-md-heart"></i>12
      </button>
      <h2 class="photo-detail__title">
        <i class="icon icon-md-chatboxes"></i>Comments
      </h2>
    </div>
  </div>
</template>


<script>
import { OK } from '../util'

export default {
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      post: null
    }
  },
  methods: {
    async fetchPost () {
      const response = await axios.get(`/api/posts/${this.id}`)
      console.log(response.data);

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.post = response.data
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchPost()
      },
      immediate: true
    }
  }
}
</script>
