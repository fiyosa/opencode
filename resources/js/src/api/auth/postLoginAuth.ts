import { axiosLib } from '../../lib'

export interface IProps {
  payload: {
    email: string
    password: string
  }
}

export const postLoginAuth = async (props: IProps) => {
  return await axiosLib.instance
    .post('/login', props.payload)
    .then((res) => res)
    .catch((res) => axiosLib.throwAxios(res))
}
