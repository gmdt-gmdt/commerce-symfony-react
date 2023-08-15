import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import { BASE_URL } from "../utils/apiURL";
import { STATUS } from "../utils/status";

const initialState = {
  user: null,
  userStatus: STATUS.IDLE,
  error: null,
};

export const registerUser = createAsyncThunk(
  "user/register",
  async (formData) => {
    console.log(formData);
    const response = await fetch(`${BASE_URL}user/register`, {
      method: "POST",
      body: JSON.stringify(formData),
    });
    const data = await response.json();
    console.log(data);
    return data;
  }
);

export const loginUser = createAsyncThunk("user/login", async (formData) => {
  const response = await fetch(`${BASE_URL}user/login`, {
    method: "POST",
    body: JSON.stringify(formData),
  });
  const data = await response.json();
  return data;
});

const userSlice = createSlice({
  name: "user",
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder
      .addCase(registerUser.pending, (state) => {
        state.userStatus = STATUS.LOADING;
      })
      .addCase(registerUser.fulfilled, (state, action) => {
        state.user = action.payload.user;
        state.userStatus = STATUS.SUCCEEDED;
        state.error = null;
      })
      .addCase(registerUser.rejected, (state, action) => {
        state.userStatus = STATUS.FAILED;
        state.error = action.error.message;
      })
      .addCase(loginUser.pending, (state) => {
        state.userStatus = STATUS.LOADING;
      })
      .addCase(loginUser.fulfilled, (state, action) => {
        state.user = action.payload.user;
        state.userStatus = STATUS.SUCCEEDED;
        state.error = null;
      })
      .addCase(loginUser.rejected, (state, action) => {
        state.userStatus = STATUS.FAILED;
        state.error = action.error.message;
      });
  },
});

export const getUser = (state) => state.user.user;
export const getUserStatus = (state) => state.user.userStatus;
export const getUserError = (state) => state.user.error;

export default userSlice.reducer;
