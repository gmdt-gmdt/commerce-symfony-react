import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import {
  registerUser,
  getUserStatus,
  getUserError,
  getUser,
} from "../../store/userSlice";
import Loader from "../../components/Loader/Loader";
import { STATUS } from "../../utils/status";

import "./RegisterPage.scss";
import { useNavigate } from "react-router-dom";

const RegisterPage = () => {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    email: "",
    password: "",
    firstname: "",
    lastname: "",
    zipcode: "",
    city: "",
    address: "",
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
    dispatch(registerUser(formData));
  };
  useEffect(() => {
    if (user) navigate("/");
  }, [user]);

  return (
    <div className="register-form py-5">
      <div className="container">
        <div className="register-form-content">
          <div className="title-md">
            <h3>Create an Account</h3>
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
            <div className="form-row">
              <div className="col-md-6 form-group">
                <label htmlFor="firstname">First Name</label>
                <input
                  type="text"
                  id="firstname"
                  name="firstname"
                  value={formData.firstname}
                  onChange={handleInputChange}
                  required
                  className="form-control"
                />
              </div>
              <div className="col-md-6 form-group">
                <label htmlFor="lastname">Last Name</label>
                <input
                  type="text"
                  id="lastname"
                  name="lastname"
                  value={formData.lastname}
                  onChange={handleInputChange}
                  required
                  className="form-control"
                />
              </div>
            </div>
            <div className="form-row">
              <div className="col-md-4 form-group">
                <label htmlFor="zipcode">Zip Code</label>
                <input
                  type="text"
                  id="zipcode"
                  name="zipcode"
                  value={formData.zipcode}
                  onChange={handleInputChange}
                  required
                  className="form-control"
                />
              </div>
              <div className="col-md-4 form-group">
                <label htmlFor="city">City</label>
                <input
                  type="text"
                  id="city"
                  name="city"
                  value={formData.city}
                  onChange={handleInputChange}
                  required
                  className="form-control"
                />
              </div>
              <div className="col-md-4 form-group">
                <label htmlFor="address">Address</label>
                <input
                  type="text"
                  id="address"
                  name="address"
                  value={formData.address}
                  onChange={handleInputChange}
                  required
                  className="form-control"
                />
              </div>
            </div>
            <button type="submit" className="btn register-btn">
              {userStatus === STATUS.LOADING ? <Loader /> : "Register"}
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

export default RegisterPage;
