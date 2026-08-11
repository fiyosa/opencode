import { axiosLib } from '../../lib'

export const getUser = async (id: number | string) => {
  return await axiosLib.instance
    .get(`/users/${id}`)
    .then((res) => res)
    .catch((res) => axiosLib.throwAxios(res))
}
