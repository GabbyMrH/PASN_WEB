<template>
  <div v-loading="loading" class="app-container">
    <el-form ref="form" :rules="formRules" :inline="true" :model="outBoundForm" label-width="120px">
      <!-- 表单头部 -->
      <el-card class="box-card">
        <div style="display: flex; box-shadow: 0px 2px 1px 2px #ebeef5;margin-bottom: 20px;">
          <div style="width: 50%;">
            <el-form-item label="客户参考号" prop="ref_no">
              <el-input v-model="outBoundForm.ref_no" :disabled="formDisable" />
            </el-form-item>
            <el-form-item label="客户编码" prop="customer_id">
              <el-input v-model="outBoundForm.customer_id" :disabled="formDisable" />
            </el-form-item>
            <el-form-item label="订单日期" prop="issue_date">
              <el-date-picker
                v-model="outBoundForm.issue_date"
                type="datetime"
                placeholder="选择日期时间"
                :disabled="formDisable"
                format="yyyy-MM-dd HH:mm:ss"
                style="width:85%;"
              />
            </el-form-item>
            <el-form-item label="仓库编码" prop="warehouse_code" label-width="90px">
              <el-select
                v-model="outBoundForm.warehouse_code"
                :loading="selectLoading"
                placeholder="请选择"
                :disabled="formDisable"
                style="width: 90%;"
                @focus="getWarehouseList"
              >
                <el-option
                  v-for="(item, index) in warehouseList"
                  :key="index"
                  :label="item.warehouse_code"
                  :value="item.warehouse_code"
                />
              </el-select>
            </el-form-item>
          </div>
          <el-divider direction="vertical" />
          <div style="width: 50%;">
            <el-form-item label="装柜方式" prop="container_loadtype">
              <el-select v-model="outBoundForm.container_loadtype" placeholder="请选择" :disabled="formDisable">
                <el-option
                  v-for="(item, index) in containerLoadtypeList"
                  :key="index"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="派车方式" prop="truckorder_type">
              <el-select v-model="outBoundForm.truckorder_type" placeholder="请选择" :disabled="formDisable">
                <el-option
                  v-for="(item, index) in truckorderTypeList"
                  :key="index"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="集装箱类型" prop="container_type">
              <el-select v-model="outBoundForm.container_type" placeholder="请选择" :disabled="formDisable">
                <el-option
                  v-for="(item, index) in containerTypeList"
                  :key="index"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="集装箱号" prop="container_no">
              <el-input v-model="outBoundForm.container_no" placeholder="集装箱号" style="width: 12rem;" :disabled="formDisable" />
            </el-form-item>
            <el-form-item label="车型" prop="truck_type">
              <el-input v-model="outBoundForm.truck_type" placeholder="车型" style="width: 12rem;" :disabled="formDisable" />
            </el-form-item>
            <el-form-item label="车牌号" prop="truck_no">
              <el-input v-model="outBoundForm.truck_no" placeholder="车牌号" style="width: 12rem;" :disabled="formDisable" />
            </el-form-item>
          </div>
        </div>
        <el-row type="flex" justify="center">
          <el-form-item label="总数量" prop="order_qty">
            <el-input v-model="outBoundForm.order_qty" :disabled="formDisable" />
          </el-form-item>
          <el-form-item label="总体积" prop="order_cbm">
            <el-input v-model="outBoundForm.order_cbm" :disabled="formDisable" />
          </el-form-item>
          <el-form-item label="总重量" prop="order_gw">
            <el-input v-model="outBoundForm.order_gw" :disabled="formDisable" />
          </el-form-item>
        </el-row>
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
            :data="outBoundForm.details"
            :stripe="true"
            :border="true"
            :header-cell-style="{background:'#ebeef5'}"
            highlight-current-row
            style="width: 100%"
            :row-style="{cursor: 'pointer'}"
            @row-click="selectRowFunc"
          >
            <el-table-column type="index" align="center" label="序号" width="55" />
            <el-table-column prop="line_num" label="行号" align="center" />
            <el-table-column prop="ref_no" label="客户参考号" align="center" />
            <el-table-column prop="po_no" label="PO#" align="center" />
            <el-table-column prop="qty_case" label="数量/箱数" align="center" />
            <el-table-column align="center" prop="sku_ename" label="商品名称" />
            <el-table-column align="center" prop="fba_warehouse" label="FBA仓库代码" />
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
        <el-form-item label="行号">
          <el-input v-model="dialogForm.line_num" />
        </el-form-item>
        <el-form-item label="客户参考号">
          <el-input v-model="outBoundForm.ref_no" disabled />
        </el-form-item>
        <el-form-item label="PO#">
          <el-input v-model="dialogForm.po_no" />
        </el-form-item>
        <el-form-item label="数量/箱数">
          <el-input v-model="dialogForm.qty_case" />
        </el-form-item>
        <el-form-item label="商品名称">
          <el-input v-model="dialogForm.sku_ename" />
        </el-form-item>
        <el-form-item label="FBA仓库代码">
          <el-input v-model="dialogForm.fba_warehouse " />
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
import { queryInsert, queryDetailList, queryDetailEdit, queryDeleteDetaill } from '@/api/outbound'
import { warehouseList } from '@/api/common'
import Custom from '@/components/UploadExcel/custom'
export default {
  name: 'OutBoundCreateOrUpdate',
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
    outBoundForm: {
      ref_no: '',
      customer_id: '',
      issue_date: new Date(),
      warehouse_code: '',
      details: null,
      detail_total: '',
      container_loadtype: '',
      truckorder_type: '',
      container_type: '',
      container_no: '',
      truck_type: '',
      truck_no: '',
      order_qty: '',
      order_cbm: '',
      order_gw: ''
    },
    dialogForm: {
      line_num: '',
      ref_no: '',
      po_no: '',
      qty_case: '',
      sku_ename: '',
      fba_warehouse: ''
    },
    // 表格详情页数据
    // details: null,
    // 仓库列表
    warehouseList: null,
    // 装柜方式
    containerLoadtypeList: [{
      label: 'FCL',
      value: 'FCL'
    }, {
      label: 'LCL',
      value: 'LCL'
    }],
    // 派车方式
    truckorderTypeList: [{
      label: '自派',
      value: 'CLIENT'
    }, {
      label: '委托',
      value: 'ORDER'
    }],
    // 集装箱类型
    containerTypeList: [{
      label: '20',
      value: '20'
    }, {
      label: '40',
      value: '40'
    }, {
      label: '45',
      value: '45'
    }],
    // 验证规则
    formRules: {
      ref_no: [
        { required: true, message: '客户参考号必填', trigger: 'blur' }
      ],
      customer_id: [
        { required: true, message: '客户编码必填', trigger: 'blur' }
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
        this.outBoundForm = {}
      }
    },
    // 获取excel模板服务端路径，需剔除api版本号
    getExcelTemplate() {
      const baseUrl = process.env.VUE_APP_BASE_API
      const serverUrl = baseUrl.replace('/v1', '')
      // 组合服务器端url，当前暂时写死
      this.excelTemplateUrl = serverUrl + '/assets/excel/outbound-detail-list.xlsx'
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
      queryDetailList({ issue_id: this.inBoundParams.issue_id }).then(response => {
        // 有值
        if (response.data !== null) {
          this.outBoundForm = Object.assign(this.outBoundForm, response.data)
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
        this.outBoundForm.details = arrData
        // 写入数据
        queryInsert(this.outBoundForm).then(respone => {
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
          this.outBoundForm.details = results
          // 写入数据
          queryInsert(this.outBoundForm).then(respone => {
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
        outboundid: '',
        details: null
      }
      const arrData = []
      arrData.push(this.dialogForm)
      editData.outboundid = this.dialogForm.outboundid
      editData.details = arrData
      // 编辑
      queryDetailEdit(editData).then(response => {
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
      queryDeleteDetaill({ outboundid: row.outboundid }).then(response => {
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

<style lang="scss" scoped>
  .el-divider--vertical{
    height: 10rem !important;
  }
</style>
