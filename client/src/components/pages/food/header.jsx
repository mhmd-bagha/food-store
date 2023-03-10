import {FiHeart} from "react-icons/fi";
import Back from "../../tools/back";
import {useCallback, useEffect} from "react";

const Header = ({addFavorite, foodId, userId, favorite}) => {
    foodId = parseInt(foodId) // change typeof food id to int

    // default color icon add to favorite
    const defaultColor = 'text-white'

    const addFoodFavorite = () => {
        addFavorite({food_id: foodId, user_id: userId})
        setColorFavorite('color-red_coral')
    }

    // set color
    const setColorFavorite = (color) => {
        const favorite_icon = document.getElementById('favorite_icon')
        return favorite_icon.classList.add(color)
    }

    const existFoodFavorite = useCallback(() => {
        let colorActiveFoodFavorite = defaultColor

        if (favorite.favorite && favorite.favorite.find(({id, user_id}) => user_id === userId && id === foodId))
            colorActiveFoodFavorite = 'color-red_coral'

        setColorFavorite(colorActiveFoodFavorite)
    }, [favorite, userId, foodId])

    useEffect(() => {
        existFoodFavorite()
    }, [existFoodFavorite])

    return (
        <>
            {/* header */}
            <div className="flex justify-between">
                <Back/>
                <button type="button" className="bg_dark p-2.5 rounded-2xl border border-gray-700"
                        onClick={addFoodFavorite}><FiHeart size={17} id='favorite_icon'/>
                </button>
            </div>
        </>
    )
}
export default Header