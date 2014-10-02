@extends('laravel-kss::layouts.kss')

@section('title'){{ $meta['title'] }}@stop

@section('content')

    <nav role="primary">
       <ul>
          <li><a href="/{{Config::get('laravel-kss::uri')}}">Home</a></li>
    			@foreach ( $kssParser->getTopLevelSections() as $topLevelSection )
    				<li>
    				    <a href="/{{Config::get('laravel-kss::uri').'?reference='.$topLevelSection->getReference()}}" title="{{$topLevelSection->getDescription()}}">{{$topLevelSection->getTitle()}}</a>
    				</li>
    			@endforeach
       </ul>
    </nav>

    @if ($section === false)

        <h1>Style Guide</h1>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

    @else

        <h1>{{ $section->getTitle() }}</h1>

        @foreach( $kssParser->getSectionChildren($reference) as $child )

        <div class="styleguide" id="r{{ $child->getReference() }}">
    	    <h3 class="styleguide__header">
    	        <span class="styleguide__reference">{{ $child->getReference() }}</span>
    	        <span class="styleguide__title">{{ $child->getTitle() }}</span>
    	        <span class="styleguide__filename">{{ $child->getFilename() }}</span>
    	    </h3>

    	    <div class="styleguide__description">
    	        <p>{{ nl2br($child->getDescription()) }}</p>
    	        @if( count($child->getModifiers()) > 0 )
    	            <ul class="styleguide__modifiers">
    	                @foreach ($child->getModifiers() as $modifier)
    	                    <li>
    	                        <span class="styleguide__modifier-name {{ ($modifier->isExtender()) ? 'styleguide__modifier-name--extender' : '' }}">
    	                            {{ $modifier->getName() }}
    	                        </span>
    	                            @if ($modifier->isExtender())
    	                                @extend
    	                                <span class="styleguide__modifier-name">{{ $modifier->getExtendedClass() }}</span>
    	                            @endif
    	                        @if ($modifier->getDescription())
    	                            - {{ $modifier->getDescription() }}
    	                        @endif
    	                    </li>
    	                @endforeach
    	            </ul>
    	        @endif
    	    </div>

    	    <div class="styleguide__elements">
    	        <div class="styleguide__element">
    	            {{ $child->getMarkupNormal() }}
    	        </div>
    	        @foreach ( $child->getModifiers() as $modifier )
    	            <div class="styleguide__element styleguide__element--modifier {{ ($modifier->isExtender()) ? 'styleguide__element--extender' : ''}}">
    	                <span class="styleguide__element__modifier-label {{ ($modifier->isExtender()) ? 'styleguide__element__modifier-label--extender' : ''}}">{{ $modifier->getName() }}</span>
    	                {{ $modifier->getExampleHtml() }}
    	            </div>
    	        @endforeach
    	    </div>

    	    <div class="styleguide__html">
    	        <pre class="styleguide__code"><code>{{ htmlentities($child->getMarkupNormal('{class}')) }}</code></pre>
    	    </div>
    	</div>

    @endforeach

  @endif

@stop