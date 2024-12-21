<?php 

if(!function_exists('route_is')){
    function route_is($route=null){
        if(Request::routeIs($route)){
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('route_is')){
    function route_is($routes=[]){
        foreach($routes as $route){
            if(Request::routeIs($route)){
                return true;
            }else{
                return false;
            }
        }
    }
}

if(!function_exists('getcontractorid')){
    function getcontractorid($id){
        $contractor = \App\Models\ContractorProfile::where('user_id',$id)
                            ->whereDoesntHave('users', function ($query) {
                                $query->where('role_id', 1);
                            })->first();
        return (!empty($contractor) ? $contractor->id : null);
    }
}

if(!function_exists('getBalance')){
    function getBalance($service)
    {
        $prices = [
            'Air Conditioning' => 100,
            'Repair/service' => 50,
            'Carpentry' => 100,
            'Concrete' => 100,
            'Drywall' => 65,
            'Painting' => 100,
            'Electrical' => 120,
            'Plumbing' => 120,
            'Remodeling' => 65,
            'Roofing' => 120,
            'Repair' => 65,
            'Pest Control' => 65,
            'Handyman' => 45
        ];

        // Check if the service exists in the prices array
        if (array_key_exists($service, $prices)) {
            return $prices[$service];
        } 
    }
}