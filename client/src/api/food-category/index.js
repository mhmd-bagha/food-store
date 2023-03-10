import axiosInstance from "../baseUrl";
import {errorApiFoodCategory, setDataFoodCategory, startApiFoodCategory} from "../../states/actions/food-category";

const getFoodCategory = async (dispatch) => {
    dispatch(startApiFoodCategory)
    try {
        const res = await axiosInstance.post('/food/categories')
        dispatch(setDataFoodCategory(res.data))
    } catch (err) {
        dispatch(errorApiFoodCategory(err.data))
    }
}
export default getFoodCategory