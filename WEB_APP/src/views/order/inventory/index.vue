<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="listQuery.warehouse_code" clearable :placeholder="$t('table.warehouse_code')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-input v-model="listQuery.sku_no" clearable :placeholder="$t('table.sku_no')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-input v-model="listQuery.po_no" clearable :placeholder="$t('table.po_no')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        {{ $t('table.search') }}
      </el-button>
      <el-button v-waves :loading="downloadLoading" class="filter-item" type="primary" icon="el-icon-download" @click="handleDownload">
        {{ $t('table.export') }}
      </el-button>
    </div>

    <el-table
      :key="tableKey"
      v-loading="listLoading"
      :data="list"
      border
      fit
      :header-cell-style="{background:'#ebeef5'}"
      style="width: 100%;"
      @sort-change="sortChange"
    >
      <el-table-column type="index" align="center" />
      <el-table-column :label="$t('table.create_date')" align="center">
        <template slot-scope="{row}">
          <span>{{ row.create_date | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.warehouse_code')" align="center" width="100px">
        <template slot-scope="{row}">
          <span>{{ row.warehouse_code }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.ref_no')" align="center" width="150px">
        <template slot-scope="{row}">
          <span>{{ row.ref_no }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.po_no')" align="center">
        <template slot-scope="{row}">
          <span>{{ row.po_no }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.location_code')" align="center" width="150px">
        <template slot-scope="{row}">
          <span>{{ row.location_code }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.sku_no')" align="center">
        <template slot-scope="{row}">
          <span>{{ row.sku_no }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.drap_id')" align="center" class-name="status-col">
        <template slot-scope="{row}">
          <span>{{ row.drap_id }}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.qty')" align="center" width="100px" class-name="small-padding fixed-width">
        <template slot-scope="{row}">
          <span>{{ row.qty }}</span>
        </template>
      </el-table-column>
    </el-table>

    <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.page_limit" @pagination="getList" />
  </div>
</template>

<script>
import { inventory } from '@/api/inventory'
import waves from '@/directive/waves' // waves directive
import { parseTime } from '@/utils'
import Pagination from '@/components/Pagination' // secondary package based on el-pagination

export default {
  name: 'ComplexTable',
  components: { Pagination },
  directives: { waves },
  data() {
    return {
      tableKey: 0,
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        page_limit: 20,
        warehouse_code: undefined,
        sku_no: undefined,
        po_no: undefined
      },
      downloadLoading: false
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      this.listLoading = true
      inventory(this.listQuery).then(response => {
        this.list = response.data.data
        console.log(response.data.data)
        this.total = response.data.total

        // 关闭加载按钮
        this.listLoading = false
      })
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
    sortChange(data) {
      const { prop, order } = data
      if (prop === 'id') {
        this.sortByID(order)
      }
    },
    sortByID(order) {
      if (order === 'ascending') {
        this.listQuery.sort = '+id'
      } else {
        this.listQuery.sort = '-id'
      }
      this.handleFilter()
    },
    handleDownload() {
      this.downloadLoading = true
        import('@/vendor/Export2Excel').then(excel => {
          const tHeader = ['收货日期', '仓库', '客户参考号', 'PO#', '库位', 'FBA#', '板号', '数量']
          const filterVal = ['create_date', 'warehouse_code', 'customer_id', 'po_no', 'location_code', 'sku_no', 'drap_id', 'qty']
          const data = this.formatJson(filterVal, this.list)
          excel.export_json_to_excel({
            header: tHeader,
            data,
            filename: 'inventory-list'
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
