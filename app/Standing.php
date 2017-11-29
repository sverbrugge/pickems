<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\User;
use App\League;
use App\Season;
use App\Race;

use App\Collections\StandingCollection;

class Standing extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'race_id', 'user_id' ];

	/**
	* The "booting" method of the model.
	*
	* @return void
	*/
	protected static function boot()
	{
		parent::boot();
		
		static::addGlobalScope('sortByRaceRank', function (Builder $builder) {
		    $builder->orderBy('race_id', 'asc')->orderBy('rank', 'asc');
		});
	}

	/**
	* Creates a new Collection instance of this model.
	*
	* @param	array	$models
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function newCollection( array $models = [] )
	{
		return new StandingCollection( $models );
	}

	/**
	 * Get the race of this standings entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function race()
	{
		return $this->belongsTo( Race::class );
	}
	
	/**
	 * Get the league of this standings entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function league()
	{
		return $this->belongsTo( League::class );
	}
	
	/**
	 * Get the user of this standings entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function user()
	{
		return $this->belongsTo( User::class );
	}
	
	/**
	 * Get the previous race entry of this standings entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function previous()
	{
		return $this->belongsTo( Standing::class, 'previous_id' );
	}
	
	/**
	 * Scope to race.
	 *
	 * @param	\Illuminate\Database\Eloquent\Builder	$query
	 * @param	\App\Race				$race
	 *
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByRace( Builder $query, Race $race )
	{
		return $query->where( 'race_id', $race->id );
	}

	/**
	 * Scope to season.
	 *
	 * @param	\Illuminate\Database\Eloquent\Builder	$query
	 * @param	\App\Season				$season
	 *
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeBySeason( Builder $query, Season $season )
	{
		return $query->whereIn( 'race_id', $season->races->pluck('id') );
	}

	/**
	 * Scope to user.
	 *
	 * @param	\Illuminate\Database\Eloquent\Builder	$query
	 * @param	\App\User				$user
	 *
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByUser( Builder $query, User $user )
	{
		return $query->where( 'user_id', $user->id );
	}

	/**
	 * Scope to league.
	 *
	 * @param	\Illuminate\Database\Eloquent\Builder	$query
	 * @param	\App\League				$league
	 *
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByLeague( Builder $query, League $league )
	{
		return $query->where( 'league_id', $league->id );
	}

	/**
	 * Get the difference between current rank and previous rank
	 *
	 * @return	integer|null
	 */
	public function getRankMovedAttribute()
	{
		if( is_null( $this->previous_rank ) )
			return null;
		
		return $this->previous_rank - $this->rank;
	}
	
	/**
	 * Get the correct glyphicon class according to rankMoved.
	 *
	 * @return	string
	 */
	public function getRankMovedGlyphiconAttribute()
	{
		if( is_null( $this->rankMoved ) )
			return 'glyphicon-star';

		if( $this->rankMoved < 0 )		
			return 'glyphicon-arrow-down text-danger';

		if( $this->rankMoved > 0 )			
			return 'glyphicon-arrow-up text-success';
		
		return 'glyphicon-pause text-info';
	}
}
