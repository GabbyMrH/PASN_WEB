import request from '@/utils/request'

// 余额查询
export function inventory(query) {
  return request({
    url: '/inventory',
    method: 'get',
    params: query
  })
}

