package ru.pavlenty.authserverexample;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.POST;
import ru.pavlenty.authserverexample.models.ServerRequest;
import ru.pavlenty.authserverexample.models.ServerResponse;

public interface RequestInterface {
    @POST("http://195.19.44.146/auth/")
    Call<ServerResponse> operation(@Body ServerRequest request);
}