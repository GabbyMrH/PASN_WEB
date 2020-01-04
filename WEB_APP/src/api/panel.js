import request from '@/utils/request'

// 余额总量
export function inventoryTotal() {
  return request({
    url: 'inventoryTotal',
    method: 'get'
  })
}
