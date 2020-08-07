<template>
<div style="padding:30px">
  <a-card hoverable style="width: 300px">
    <img
      slot="cover"
      alt="example"
      src="https://gw.alipayobjects.com/zos/rmsportal/JiqGstEfoWAOHiTxclqi.png"
    />
    <template slot="actions" class="ant-card-actions">
      <a-icon key="setting" type="setting" />
      <a-icon key="edit" type="edit" />
      <a-icon key="ellipsis" type="ellipsis" />
    </template>a
    <a-card-meta :title="currentUser.name" :description="currentUser.email">
      <a-avatar
        slot="avatar"
        src="https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png"
      />
      <div>
        </div>
    </a-card-meta>
  </a-card>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
export default {
  computed: mapGetters(['currentUser']),
  created(){
    if(this.currentUser === null) this.getCurrentUser()
  },
  methods: {
    ...mapActions(['getCurrentUser'])
  }
}
</script>
