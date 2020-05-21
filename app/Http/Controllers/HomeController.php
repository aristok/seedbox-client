<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected const CLIENT_SECRET = "3f1233b14d5457b263b443a8eaf253a0";

    protected const BASE_HEADER = [
        'client' => HomeController::CLIENT_SECRET,
        'Accept' => 'application/json',
    ];


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param null $options
     * @return array
     */
    protected function getHeader($options = null): array
    {
        return $options
            ? array_merge(HomeController::BASE_HEADER, $options)
            : HomeController::BASE_HEADER;
    }

    /**
     * @return array
     */
    protected function getGuzzleClient(): \GuzzleHttp\Client
    {
        return new \GuzzleHttp\Client([
            'base_uri' => 'http://webservers.test/api/v1/',
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $request = $this
            ->getGuzzleClient()
            ->get(
                'webservers',
                [
                    'headers' => $this->getHeader()
                ]
            );

        $response = json_decode($request->getBody(), true);

        if (false === Arr::get($response, 'success', false)) {
            dd('todo: handle error condition');
        }

        return view('home', ['webservers' => $response['result']]);
    }

    /**
     * @param Request $request
     */
    public function create(Request $request)
    {
        $json = [
            'status' => $request->status,
            'fqdn' => $request->fqdn,
            'description' => $request->description
        ];

        $request = $this
            ->getGuzzleClient()
            ->request('POST',
                'webservers',
                [
                    'headers' => $this->getHeader(['Content-Type' => 'application/json']),
                    'body' => json_encode($json)
                ]
            );

        $response = json_decode($request->getBody(), true);
        // todo add some error handling we could pass the problematic fields so we can highlight were the error is
        return redirect('home');
    }
}
