import axiosInstance from "../baseUrl";
import {errorApiFood, setDataFood, startApiFood} from "../../states/actions/food";

const getFoods = async (dispatch) => {
    dispatch(startApiFood())
    const res = await axiosInstance.post('/food/all');
    try {
        dispatch(setDataFood(res.data.data))
    } catch (err) {
        dispatch(errorApiFood(err.data))
    }
}

export default getFoods