import React from "react";
import "./Footer.scss";
import { Link } from "react-router-dom";

const Footer = () => {
  return (
    <footer className="footer">
      <div className="container py-4 text-center">
        <div className="flex align-center justify-center text-white fw-3 fs-14">
          <Link to="/" className="text-uppercase">
            Privacy policy
          </Link>
          <div className="vert-line"></div>
          <Link to="/" className="text-uppercase">
            Perm of service
          </Link>
          <div className="vert-line"></div>
          <Link to="/" className="text-uppercase">
            About AlNadjah
          </Link>
        </div>
        <span className="text-white copyright-text text-manrope fs-14 fw-3">
          &copy; 2022 AlNadjah. All Rights Reserved.
        </span>
      </div>
    </footer>
  );
};

export default Footer;
