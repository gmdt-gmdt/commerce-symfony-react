import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import {
  getUserStatus,
  getUserError,
  getUser,
  loginUser,
} from "../../store/userSlice";
import Loader from "../../components/Loader/Loader";
import { STATUS } from "../../utils/status";

import "./RegisterPage.scss";
import { useNavigate } from "react-router-dom";

const LoginPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    email: "",
    password: "",
  });

  const userStatus = useSelector(getUserStatus);
  const user = useSelector(getUser);
  const userError = useSelector(getUserError);

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevFormData) => ({
      ...prevFormData,
      [name]: value,
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    dispatch(loginUser(formData));
  };
  useEffect(() => {
    if (user) navigate("/");
  }, [user]);

  return (
    <div className="register-form py-5">
      <div className="container">
        <div className="register-form-content">
          <div className="title-md">
            <h3> Log In ------ </h3>
          </div>
          <form className="registration-form" onSubmit={handleSubmit}>
            <div className="form-group">
              <label htmlFor="email">Email</label>
              <input
                type="email"
                id="email"
                name="email"
                value={formData.email}
                onChange={handleInputChange}
                required
                className="form-control"
              />
            </div>
            <div className="form-group">
              <label htmlFor="password">Password</label>
              <input
                type="password"
                id="password"
                name="password"
                value={formData.password}
                onChange={handleInputChange}
                required
                className="form-control"
              />
            </div>

            <button type="submit" className="btn register-btn">
              {userStatus === STATUS.LOADING ? <Loader /> : "Log In"}
            </button>
            {userStatus === STATUS.FAILED && (
              <p className="error-message">{userError}</p>
            )}
          </form>
        </div>
      </div>
    </div>
  );
};

export default LoginPage;
