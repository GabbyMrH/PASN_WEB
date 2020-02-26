import request from '@/utils/request'

// 余额总量
export function inventoryTotal() {
  return request({
    url: 'inventory',
    method: 'get',
    params: { page: 1, page_limit: 20 }
  })
}
