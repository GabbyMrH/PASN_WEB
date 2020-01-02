import request from '@/utils/request'

export function login(data) {
  return request({
    url: '/user',
    method: 'post',
    data
  })
}

export function getInfo(token) {
  return request({
    url: '/user',
    method: 'get',
    params: { token }
  })
}

export function logout(token) {
  return request({
    url: '/user/current',
    method: 'delete'
    // 删除token需要传递该格式参数
    // headers: {
    //   'Authorization': `Bearer ${token}`
    // }
  })
}
