<template>
  <div v-loading="loading" class="app-container">
    <el-form ref="form" :rules="formRules" :inline="true" :model="inBoundForm" label-width="120px">
      <!-- 表单头部 -->
      <el-card class="box-card">
        <el-form-item label="客户参考号" prop="ref_no">
          <el-input v-model="inBoundForm.ref_no" :disabled="formDisable" />
        </el-form-item>
        <el-form-item label="客户编码" prop="customer_id">
          <el-input v-model="inBoundForm.customer_id" :disabled="formDisable" />
        </el-form-item>
        <el-form-item label="创建日期" prop="booking_date">
          <el-date-picker
            v-model="inBoundForm.booking_date"
            type="datetime"
            placeholder="选择日期时间"
            :disabled="formDisable"
            format="yyyy-MM-dd HH:mm:ss"
          />
        </el-form-item>
        <el-form-item label="仓库编码" prop="warehouse_code">
          <el-select v-model="inBoundForm.warehouse_code" :loading="selectLoading" placeholder="请选择" :disabled="formDisable" @focus="getWarehouseList">
            <el-option
              v-for="(item, index) in warehouseList"
              :key="index"
              :label="item.warehouse_code"
              :value="item.warehouse_code"
            />
          </el-select>
        </el-form-item>
      </el-card>
      <!-- 表格部分 -->
      <el-card class="box-card" style="margin-top: 20px;">
        <div slot="header" class="clearfix">
          <el-button v-if="status ==='create'" icon="el-icon-plus" size="small" plain @click="handleCreate('form')">增加</el-button>
          <!-- <el-button icon="el-icon-delete" type="danger" size="small" plain>删除</el-button>-->
          <!-- <el-button v-if="status ==='create'" icon="el-icon-upload" type="primary" size="small" plain>导入</el-button>-->
          <custom v-if="status ==='create'" :on-success="handleUploadSuccess" />
          <el-link v-if="status ==='create'" :href="excelTemplateUrl" type="warning" style="margin-left: 10px;" target="_blank">Excel模板下载</el-link>
        </div>
        <div>
          <el-table
            ref="inBoundTable"
            :data="booking_detail"
            :stripe="true"
            :border="true"
            :header-cell-style="{background:'#ebeef5'}"
            highlight-current-row
            style="width: 100%"
            :row-style="{cursor: 'pointer'}"
            @row-click="selectRowFunc"
          >
            <el-table-column type="index" align="center" label="序号" width="55" />
            <el-table-column prop="ref_no" label="客户参考号" align="center" />
            <el-table-column prop="po_no" label="PO#" align="center" />
            <el-table-column prop="qty_case" label="数量/箱数" align="center" />
            <el-table-column align="center" prop="country" label="国家" />
            <el-table-column align="center" prop="case_length" label="长" />
            <el-table-column align="center" prop="case_width" label="宽" />
            <el-table-column align="center" prop="case_height" label="高" />
            <el-table-column align="center" prop="case_weight" label="重" />
            <el-table-column v-if="status === 'update'" align="center" label="操作">
              <template v-slot="{row}">
                <el-button type="primary" size="mini" @click="handleEdit(row)">编辑</el-button>
                <el-button type="danger" size="mini" @click="handleDelete(row)">删除</el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </el-card>
    </el-form>
    <!-- dialog子组件 -->
    <el-dialog
      title="提示"
      :visible.sync="dialogVisible"
      width="35%"
    >
      <el-form ref="dialogForm" :inline="true" :model="dialogForm" label-width="80px">
        <el-form-item label="客户参考号">
          <el-input v-model="inBoundForm.ref_no" disabled />
        </el-form-item>
        <el-form-item label="PO#">
          <el-input v-model="dialogForm.po_no" />
        </el-form-item>
        <el-form-item label="国家">
          <el-input v-model="dialogForm.country" />
        </el-form-item>
        <el-form-item label="数量/箱数">
          <el-input v-model="dialogForm.qty_case" />
        </el-form-item>
        <el-form-item label="长">
          <el-input v-model="dialogForm.case_length" />
        </el-form-item>
        <el-form-item label="宽">
          <el-input v-model="dialogForm.case_width" />
        </el-form-item>
        <el-form-item label="高">
          <el-input v-model="dialogForm.case_height" />
        </el-form-item>
        <el-form-item label="重">
          <el-input v-model="dialogForm.case_weight" />
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" @click="status === 'create'?create():update()">确 定</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import { detailList, queryInBoundAdd, queryInBoundDetailEdit, queryInBoundDetailDelete } from '@/api/inbound'
import { warehouseList } from '@/api/common'
import Custom from '@/components/UploadExcel/custom'
export default {
  name: 'InBoundCreateOrUpdate',
  components: {
    Custom
  },
  data: () => ({
    loading: false,
    selectLoading: false,
    formDisable: false,
    inBoundParams: null, // 组件传递过来的参数数据
    excelTemplateUrl: '',
    status: '',
    // 表单数据
    inBoundForm: {
      ref_no: '',
      customer_id: '',
      booking_date: new Date(),
      warehouse_code: '',
      booking_detail: null,
      booking_detail_total: ''
    },
    dialogForm: {
      ref_no: '',
      po_no: '',
      country: '',
      qty_case: '',
      case_length: '',
      case_width: '',
      case_height: '',
      case_weight: ''
    },
    // 表格详情页数据
    booking_detail: null,
    // 仓库列表
    warehouseList: null,
    // 验证规则
    formRules: {
      ref_no: [
        { required: true, message: '客户参考号必填', trigger: 'blur' }
      ],
      customer_id: [
        { required: true, message: '客户编码必填', trigger: 'blur' }
      ],
      booking_date: [
        { required: true, message: '创建日期必填', trigger: 'blur' }
      ],
      warehouse_code: [
        { required: true, message: '仓库编码必填', trigger: 'blur' }
      ]
    },
    dialogVisible: false
  }),
  created() {
    this.status = this.$route.params.status
    this.inBoundParams = this.$route.params
    this.checkInBoundStatus()
    this.getExcelTemplate()
  },
  methods: {
    // 检验当前状态
    checkInBoundStatus() {
      if (this.status === 'update') {
        this.getDetailList()
        this.formDisable = true
      } else {
        this.inBoundForm = {}
      }
    },
    // 获取excel模板服务端路径，需剔除api版本号
    getExcelTemplate() {
      const baseUrl = process.env.VUE_APP_BASE_API
      const serverUrl = baseUrl.replace('/v1', '')
      // 组合服务器端url，当前暂时写死
      this.excelTemplateUrl = serverUrl + '/assets/excel/detail-list-template.xlsx'
    },
    // 获取仓库列表
    getWarehouseList() {
      this.selectLoading = true
      warehouseList().then(response => {
        this.warehouseList = response.data
        this.selectLoading = false
      })
    },
    // 获取详情列表数据
    getDetailList() {
      this.loading = true
      detailList({ booking_id: this.inBoundParams.booking_id }).then(response => {
        // 有值
        if (response.data !== null) {
          this.inBoundForm.warehouse_code = response.data.warehouse_code
          this.inBoundForm.customer_id = response.data.customer_id
          this.inBoundForm.ref_no = response.data.ref_no
          this.inBoundForm.booking_date = response.data.booking_date
          this.booking_detail = response.data.details
        }
        this.loading = false
      })
    },
    // 获取前组件传递的参数
    // getInBoundParam() {
    //   this.inBoundParams = this.$route.params
    // },
    // 用户点击某行时选中该行
    selectRowFunc(row) {
      this.$refs.inBoundTable.toggleRowSelection(row)
    },
    // 点击增加按钮-->将改为dialog封装到子组件内
    handleCreate(form) {
      this.$refs[form].validate(valid => {
        if (valid) {
          this.dialogVisible = true
        } else {
          return false
        }
      })
    },
    // 点击dialog确定按钮
    create(val) {
      if (this.status === 'create') {
        const arrData = []
        arrData.push(this.dialogForm)
        this.inBoundForm.booking_detail = arrData
        // 写入数据
        queryInBoundAdd(this.inBoundForm).then(respone => {
          if (respone.code === 2001) {
            this.$message({
              message: '写入成功',
              type: 'success'
            })
            this.dialogVisible = false
          } else {
            this.$message.error('写入失败')
          }
        })
      }
    },
    // 上传excel
    handleUploadSuccess({ results, header }) {
      this.$refs.form.validate(valid => {
        if (valid) {
          this.inBoundForm.booking_detail = results
          // 写入数据
          queryInBoundAdd(this.inBoundForm).then(respone => {
            if (respone.code === 2001) {
              this.$message({
                message: '写入成功',
                type: 'success'
              })
              this.dialogVisible = false
            } else {
              this.$message.error('写入失败')
            }
          })
        } else {
          return false
        }
      })
    },
    // 点击编辑按钮
    handleEdit(row) {
      this.dialogVisible = true
      this.dialogForm = row
    },
    // 编辑详情单
    update() {
      const editData = {
        inboundid: '',
        booking_detail: null
      }
      const arrData = []
      arrData.push(this.dialogForm)
      editData.inboundid = this.dialogForm.inboundid
      editData.booking_detail = arrData
      // 编辑
      queryInBoundDetailEdit(editData).then(response => {
        if (response.code === 2001) {
          this.$message({
            message: '写入成功',
            type: 'success'
          })
          this.dialogVisible = false
        } else {
          this.$message.error('写入失败')
        }
      })
    },
    // 删除详情单
    handleDelete(row) {
      queryInBoundDetailDelete({ inboundid: row.inboundid }).then(response => {
        if (response.code === 2001) {
          this.$message({
            message: '删除成功',
            type: 'success'
          })
          this.getDetailList()
        } else {
          this.$message.error('删除失败')
        }
      })
    }
  }
}
</script>

<style scoped>

</style>
