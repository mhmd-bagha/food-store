import {useForm} from "react-hook-form";
import {yupResolver} from "@hookform/resolvers/yup";
import {object, string} from "yup";
import {useRef, useState} from "react";

const SignupView = ({signup, user}) => {
    const signupBtn = useRef(null)
    const [signupStatus, setSignupStatus] = useState(false) // change value signup button

    const validator = object({
        full_name: string().trim().min(3).required(),
        email: string().trim().email().required(),
        password: string().min(6).required(),
    })
    const {register, handleSubmit, formState: {errors}} = useForm({resolver: yupResolver(validator)})
    const signupHandle = (data) => {

        signupDisabled()

        signup(data).then(() => {
            signupBtn.current.disabled = false
            setSignupStatus(false)
        })
    }

    const signupDisabled = () => {
        signupBtn.current.disabled = true
        setSignupStatus(true)
    }

    return (
        <form action="/" method="post" onSubmit={handleSubmit(signupHandle)}>
            {/* full name */}
            <div className="form_group">
                <input type="text" id="full_name" className="form_input" placeholder=""
                       required {...register('full_name')}/>
                <label htmlFor="full_name" className="form_label">Full Name</label>
                <p className="text-xs error_text">{errors.full_name?.message}</p>
            </div>
            {/* email */}
            <div className="form_group">
                <input type="email" id="email" className="form_input" placeholder=""
                       required {...register('email')}/>
                <label htmlFor="email" className="form_label">Email Address</label>
                <p className="text-xs error_text">{errors.email?.message}</p>
            </div>
            {/* password */}
            <div className="form_group">
                <input type="password" id="password" className="form_input" placeholder=""
                       required {...register('password')} />
                <label htmlFor="password" className="form_label">Password</label>
                <p className="text-xs error_text">{errors.password?.message}</p>
            </div>
            {/* submit button */}
            <button type="submit"
                    className="bg_red_coral text-white text-lg font-bold w-full py-3.5 mt-10 rounded-2xl"
                    ref={signupBtn}>{signupStatus ? 'Registering...' : 'Sign up'}
            </button>
        </form>
    )
}
export default SignupView