<?php
            namespace App\adminmodel;
            use Illuminate\Contracts\Auth\MustVerifyEmail;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
            use Illuminate\Foundation\Auth\User as Authenticatable;
            use Illuminate\Notifications\Notifiable;
            use Laravel\Sanctum\HasApiTokens;
            use Illuminate\Database\Eloquent\SoftDeletes;
            class ScriptModal extends Authenticatable
            {

                protected $table='script';
                use HasApiTokens, HasFactory, Notifiable;
                /**
                 * The attributes that are mass assignable.
                 *
                 * @var array<int, string>
                 */
                protected $fillable = [
                	 'team_id',
	 'ajent_id',
	 'email_script',
	 'calling_script',
	 'text_script',
	 'my_note',

                'ip'
                ];
                use SoftDeletes;
                protected $del = ['deleted_at'];
                /**
                 * The attributes that should be hidden for serialization.
                 *
                 * @var array<int, string>
                 */

                /**
                 * The attributes that should be cast.
                 *
                 * @var array<string, string>
                 */
                protected $casts = [
                    'email_verified_at' => 'datetime',
                ];
            }
