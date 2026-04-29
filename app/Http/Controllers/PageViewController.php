<<<<<<< HEAD
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PageView;

class PageViewController extends Controller
{
    //
    
    
    public function addPageView2($page, $type){
        
        $pageView = new PageView();
        $pageView->page  = $page;
        $pageView->type  = $type;
        $pageView->save();
        
    }
    
    public function addPageView(Request $request, $page, $type){
        $source = $this->getSource($request);
        
        $pageView = new PageView();
        $pageView->page  = $page;
        $pageView->type  = $type;
        $pageView->source= $source;
        $pageView->save();
    
    }
    
    public function getSource(Request $request){
        $source = $request->utm_source;
        if(!$source){
            $source = "SELF";
        }
        
        return $source;
    }
    
    
    public function addProjectVisit(Request $request, $page, $type, $project){
        $source = $this->getSource($request);
        
        $pageView = new PageView();
        $pageView->page      = $page;
        $pageView->projectid = $project;
        $pageView->type      = $type;
        $pageView->source    = $source;
        $pageView->save();
        
    }
    
}
=======
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PageView;

class PageViewController extends Controller
{
    //
    
    
    public function addPageView2($page, $type){
        
        $pageView = new PageView();
        $pageView->page  = $page;
        $pageView->type  = $type;
        $pageView->save();
        
    }
    
    public function addPageView(Request $request, $page, $type){
        $source = $this->getSource($request);
        
        $pageView = new PageView();
        $pageView->page  = $page;
        $pageView->type  = $type;
        $pageView->source= $source;
        $pageView->save();
    
    }
    
    public function getSource(Request $request){
        $source = $request->utm_source;
        if(!$source){
            $source = "SELF";
        }
        
        return $source;
    }
    
    
    public function addProjectVisit(Request $request, $page, $type, $project){
        $source = $this->getSource($request);
        
        $pageView = new PageView();
        $pageView->page      = $page;
        $pageView->projectid = $project;
        $pageView->type      = $type;
        $pageView->source    = $source;
        $pageView->save();
        
    }
    
}
>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
