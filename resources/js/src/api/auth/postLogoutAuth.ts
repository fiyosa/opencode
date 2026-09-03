import { axiosLib } from '../../lib'

export const postLogoutAuth = async () => {
  return await axiosLib.instance
    .post('/logout')
    .then((res) => res)
    .catch((res) => axiosLib.throwAxios(res))
}
