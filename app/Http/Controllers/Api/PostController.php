<?php



namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use Exception;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {

        $query = Post::query(); /* $query donne des condition a la requette / query est une instance de l'objet constructeur */
        $perPage = 2; /* récupere 1 element par page */
        $page = $request->input('page',1);/* récupere la page actuelle qui est par defaut la page 1 pour cette ex*/
        $search = $request ->input('search');/* récupération de ce que l'acteur a tapper dans la bar recherche avec une clef search*/

        if($search){ /* condition pour voire si l'acteur a tapper une choses dans la bar de recherche ou pas */
            $query->where('titre', 'like', '%'.$search.'%');  /* titre est la colone ou nous voulons faire la recherche /méthode LIKE pour retrouver tout les enregistrement correspondent a cela / % pour faire un espace tout cela pemet une recherche avec l'équivalence de ce que l'acteur aura cesi*/
        }
            
        $total = $query->count(); /* obtenir une valeur numérique indiquant combien d'enregistrements dans la base de données correspondent à la condition de recherche spécifiée */ 

        $result = $query->offset(($page -1) *$perPage)->limit($perPage)->get(); /* effectue une pagination des résulata de la requette / en fonction de la page actuelle et du nombre de page enreistrer par page */

        return response()->json([
            'status_code'=>200,  
            'status_message'=>'Les posts on été récupéré',
            'current_page'=>$page,
            'last_page'=>ceil($total / $perPage),
            'items'=>$result
        ]);

        try{
        }catch(Exception $e)
        {
            return response()->json([
                'status_code'=>200,  /* 200 permet de dire que la ressource a été crée */
                'status_message'=>'Le post a bien été créé',
                'data'=>$post /* clef data qui sera la clef du post */ 
            ]); 
        } 
    }

    public function store(CreatePostRequest $request) /*CreatePostRequest me permet d'utilser ma methode request voulu et on identifie cette methode avec $request*/
    {
        try{
            $post = new Post();

            $post->titre = $request->titre;
            $post->description = $request->description;
            $post->save();

        return response()->json([
            'status_code'=>200,  /* 200 permet de dire que la ressource a été crée */
            'status_message'=>'Le post a bien été créé',
            'post'=>$post
        ]);
        }catch(Exception $e)
        {
            return response()->json($e); /* erreur serveur */
        }
    }

    public function update(EditPostRequest $request, $id)
    {
        try{
            $post = Post::find($id);

            $post->titre = $request ->titre;
            $post->description = $request->description;
            $post->user_id = auth()->user->id;
            $post->save();
        }catch(Exception $e)
        {
            return response()->json($e);
        } 
    }

    public function delete(Post $post){
        try{
        
            if($post->user_id == Auth::id()){
                $post->delete();

                return response()->json([
                    'status_code'=>200,  
                    'status_message'=>'Le post a bien été supprimé',
                    'post'=>$post
                ]);

            }else{
                return response()->json([
                    'status_code'=>422, 
                    'status_message'=>'Vous n\'etes pas l\'auteur de ce post',
                    'post'=>$post
                ]);
            }
            
        }catch(Exception $e)
        {
            return response()->json($e);
        } 
    }
}
