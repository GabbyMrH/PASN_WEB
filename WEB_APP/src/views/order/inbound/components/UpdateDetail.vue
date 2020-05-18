<template>
  <div class="app-container">
    <el-form ref="detailForm" :inline="true" :model="formDetail" label-width="80px">
      <el-form-item label="客户参考号">
        <el-input v-model="formDetail.ref_no" disabled />
      </el-form-item>
      <el-form-item label="PO#">
        <el-input v-model="formDetail.po_no" />
      </el-form-item>
      <el-form-item label="国家">
        <el-input v-model="formDetail.country" />
      </el-form-item>
      <el-form-item label="数量/箱数">
        <el-input v-model="formDetail.qty_case" />
      </el-form-item>
      <el-form-item label="长">
        <el-input v-model="formDetail.case_length" />
      </el-form-item>
      <el-form-item label="宽">
        <el-input v-model="formDetail.case_width" />
      </el-form-item>
      <el-form-item label="高">
        <el-input v-model="formDetail.case_height" />
      </el-form-item>
      <el-form-item label="重">
        <el-input v-model="formDetail.case_weight" />
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
  name: 'UpdateDetail',
  props: {
    formData: {
      type: Object,
      default: null
    }
  },
  data: () => ({
    detailData: null,
    formDetail: {
      ref_no: '',
      po_no: '',
      country: '',
      qty_case: '',
      case_length: '',
      case_width: '',
      case_height: '',
      case_weight: ''
    }
  }),
  computed: {
    detailChangeData() {
      return this.formData.detail
    }
  },
  watch: {
    detailChangeData(val) {
      this.formDetail = Object.assign(this.formDetail, val)
    }
  },
  created() {
    this.checkStatusData()
    this.formDetail.ref_no = this.formData.ref_no
  },
  methods: {
    checkStatusData() {
      if (this.formData.status === 'update') {
        this.formDetail = this.formData.detail
      }
    }
  }
}
</script>

<style scoped>

</style>
