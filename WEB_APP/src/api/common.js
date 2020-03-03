import request from '@/utils/request'

export function warehouseList() {
  return request({
    url: 'warehouse',
    method: 'get'
  })
}
