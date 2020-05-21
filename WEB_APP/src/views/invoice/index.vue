<template>
  <div class="app-container">
    <el-card class="box-card">
      <div>
        <el-input v-model="listQuery.invoice_no" clearable placeholder="发票号码" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
        <el-date-picker
          v-model="pickerDate"
          class="filter-item"
          type="daterange"
          align="right"
          unlink-panels
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          value-format="yyyy-MM-dd"
          :picker-options="pickerOptions"
          @change="getPickerDate"
        />
        <el-select
          v-model="listQuery.invoice_status"
          placeholder="选择状态"
          clearable="true"
        >
          <el-option
            v-for="(item, index) in invoiceStatusList"
            :key="index"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
        <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
          {{ $t('table.search') }}
        </el-button>
      </div>
    </el-card>

    <el-card class="box-card" style="margin-top: 20px;">
      <div slot="header" class="clearfix">
        <el-button v-waves :loading="downloadLoading" class="filter-item" type="primary" icon="el-icon-download" size="mini" @click="handleDownload">
          下载
        </el-button>
      </div>
      <el-table
        :key="tableKey"
        v-loading="listLoading"
        :data="invoiceList"
        border
        fit
        :header-cell-style="{background:'#ebeef5'}"
        style="width: 100%;"
      >
        <el-table-column type="selection" width="55" align="center" />
        <!--  <el-table-column type="index" align="center" label="序号" width="50" />-->
        <el-table-column label="发票号码" prop="invoice_no" align="center" />
        <el-table-column label="日期" align="center" prop="invoice_date" sortable>
          <template slot-scope="{row}">
            <span>{{ row.invoice_date | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
          </template>
        </el-table-column>
        <el-table-column label="付款日期" align="center" prop="pay_date" sortable>
          <template slot-scope="{row}">
            <span>{{ row.pay_date | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
          </template>
        </el-table-column>
        <el-table-column label="总金额" align="center" prop="amount_summary" />
        <el-table-column label="状态" align="center" prop="invoice_status">
          <template slot-scope="{row}">
            <el-tag :type="row.invoice_status | statusFilter">
              {{ row.invoice_status }}
            </el-tag>
          </template>
        </el-table-column>
        <el-table-column label="客户参考号" align="center" prop="invoice_desc" />
        <el-table-column label="操作" align="center" width="100px" class-name="small-padding fixed-width">
          <template slot-scope="{row}">
            <el-button type="warning" size="mini" @click="handleCheck(row)">审核</el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-card>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.page_limit" @pagination="getList" />
  </div>
</template>

<script>
import { queryList, queryChangeStatus } from '@/api/invoice'
import waves from '@/directive/waves' // waves directive
import { parseTime } from '@/utils'
import Pagination from '@/components/Pagination' // secondary package based on el-pagination

export default {
  name: 'Invoice',
  components: { Pagination },
  directives: { waves },
  filters: {
    statusFilter(status) {
      const statusMap = {
        DRAFT: 'info',
        RECEIPTING: 'success'
      }
      return statusMap[status]
    }
  },
  data() {
    return {
      tableKey: 0,
      invoiceList: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        page_limit: 20,
        invoice_no: '',
        start_time: null,
        end_time: null,
        invoice_status: ''
      },
      pickerDate: '',
      pickerOptions: {
        shortcuts: [{
          text: '最近一周',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '最近一个月',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '最近三个月',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
            picker.$emit('pick', [start, end])
          }
        }]
      },
      invoiceStatusList: [{
        label: 'NEW',
        value: 'NEW'
      }, {
        label: 'VERIFIED',
        value: 'VERIFIED'
      }, {
        label: 'PAID',
        value: 'PAID'
      }],
      downloadLoading: false
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      queryList(this.listQuery).then(response => {
        this.invoiceList = response.data.data
        console.log(response.data.data)
        this.total = response.data.total

        // 关闭加载按钮
        this.listLoading = false
      })
    },
    // 审核
    handleCheck(row) {
      queryChangeStatus(row).then(response => {
        if (response.code === 2001) {
          this.$message({
            message: '操作成功',
            type: 'success'
          })
          this.getList()
        } else {
          this.$message.error('删除失败')
        }
      })
    },
    // 获取选择日期
    getPickerDate(val) {
      if (val) {
        this.listQuery.start_time = val[0]
        this.listQuery.end_time = val[1]
      } else {
        this.listQuery.start_time = null
        this.listQuery.end_time = null
      }
    },
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
    handleModifyStatus(row, status) {
      this.$message({
        message: '操作成功',
        type: 'success'
      })
      row.status = status
    },
    handleDownload() {
      this.downloadLoading = true
        import('@/vendor/Export2Excel').then(excel => {
          const tHeader = ['发票号码', '日期', '付款日期', '总金额', '状态', '客户参考号']
          const filterVal = ['invoice_no', 'invoice_date', 'pay_date', 'amount_summary', 'invoice_status', 'invoice_desc']
          const data = this.formatJson(filterVal, this.invoiceList)
          excel.export_json_to_excel({
            header: tHeader,
            data,
            filename: 'invoice-list'
          })
          this.downloadLoading = false
        })
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        if (j === 'timestamp') {
          return parseTime(v[j])
        } else {
          return v[j]
        }
      }))
    },
    getSortClass: function(key) {
      const sort = this.listQuery.sort
      return sort === `+${key}`
        ? 'ascending'
        : sort === `-${key}`
          ? 'descending'
          : ''
    }
  }
}
</script>
