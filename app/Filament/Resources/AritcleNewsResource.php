<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AritcleNewsResource\Pages;
use App\Filament\Resources\AritcleNewsResource\RelationManagers;
use App\Models\ArticleNews;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AritcleNewsResource extends Resource
{
    protected static ?string $model = ArticleNews::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                forms\Components\TextInput::make('name')
                    ->required()
                    ->maxlength(255),

                forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->required(),

                forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                
                forms\Components\Select::make('author_id')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                
                forms\Components\Select::make('is_featured')
                    ->options([
                        'featured' => 'Featured',
                        'not_featured' => 'Not Featured',
                    ])
                    ->required(),
                
                forms\Components\RichEditor::make('content')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'codeBlock',
                        'heading',
                        'h2',
                        'h3',
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'heading',
                        'link',
                        'quote',
                        'code',
                        'bullet_list',
                        'ordered_list',
                        'horizontal_rule',
                        'undo',
                        'redo',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\columns\TextColumn::make('name')
                    ->searchable(),
                Tables\columns\TextColumn::make('category.name'),
                Tables\columns\TextColumn::make('author.name'),
                Tables\columns\TextColumn::make('is_featured')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'featured' => 'success',
                        'not_featured' => 'danger',
                    }),
                Tables\columns\ImageColumn::make('thumbnail')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAritcleNews::route('/'),
            'create' => Pages\CreateAritcleNews::route('/create'),
            'edit' => Pages\EditAritcleNews::route('/{record}/edit'),
        ];
    }
}
