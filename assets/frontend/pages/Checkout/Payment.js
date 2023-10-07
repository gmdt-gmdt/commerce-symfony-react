import { CardElement, useElements, useStripe } from "@stripe/react-stripe-js";

import React, { useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { clearCart } from "../../store/cartSlice";
import { STRIPE_API_URL } from "../../utils/apiURL";
import Completion from "./Completion";

export default function PaymentForm() {
  const { totalAmount } = useSelector((state) => state.cart);
  const [success, setSuccess] = useState(false);
  const stripe = useStripe();
  const elements = useElements();
  const dispatch = useDispatch();

  const handleSubmit = async (e) => {
    e.preventDefault();

    // const { error, paymentMethod } = await stripe.createPaymentMethod({
    //   type: "card",
    //   card: elements.getElement(CardElement),
    // });

    // if (!error) {
    //   try {
    //     const { id } = paymentMethod;
    //     const requestOptions = {
    //       method: "POST",
    //       headers: { "Content-Type": "application/json" },
    //       body: JSON.stringify({
    //         amount: Number(totalAmount) * 1000,
    //         id,
    //       }),
    //     };

    //     const response = await fetch(STRIPE_API_URL, requestOptions);
    //     const data = await response.json();

    //     if (data.success) {
    //       setSuccess(true);
    //       dispatch(clearCart());
    //     }
    //   } catch (error) {
    //     console.log("Error", error);
    //     window.alert("🛑Sorry🛑, backend api not deployed ⛔💥");
    //   }
    // } else {
    //   console.log(error.message);
    // }

    let paymentRequestUrl = "https://paytech.sn/api/payment/request-payment";

    const params = {
      item_name: "Iphone 7",
      item_price: "50",
      currency: "XOF",
      ref_command: "HBZZYZVUZZZV",
      command_name: "Paiement Iphone 7 Gold via PayTech",
      env: "test",
      ipn_url: "https://domaine.com/ipn",
      success_url: "https://domaine.com/success",
      cancel_url: "https://domaine.com/cancel",
      custom_field: JSON.stringify({
        custom_fiel1: "value_1",
        custom_fiel2: "value_2",
      }),
    };

    const headers = {
      Accept: "application/json",
      "Content-Type": "application/json",
      API_KEY:
        "3e52e15e777eb9e1f4783843003dcf5632ce3260190e32cdee5d2ef3d0916b78",
      API_SECRET:
        "b81c42b570768823b621161d42332c8a38f7b5573616d7eb09023d5e6d101d4e",
    };

    fetch(paymentRequestUrl, {
      method: "POST",
      body: JSON.stringify(params),
      headers,
    })
      .then(async function (response) {
        const res = await response.json();
        console.log(res);
      })
      .then(function (jsonResponse) {
        console.log(jsonResponse);
        /*
    {
        "success":1,
        "redirect_url":"https://paytech.sn/payment/checkout/98b1c97af00c8b2a92f2",
      token:"98b1c97af00c8b2a92f2"}

    */
      });
  };

  return (
    <div className="payment-container">
      {!success ? (
        <form onSubmit={handleSubmit}>
          <fieldset className="stripe-form-group">
            <div className="FormRow">{/* <CardElement /> */}</div>
          </fieldset>
          <button className="stripe-button">Pay</button>
        </form>
      ) : (
        <Completion />
      )}
    </div>
  );
}
